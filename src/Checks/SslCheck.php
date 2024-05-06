<?php

namespace Stepanenko3\NovaHealth\Checks;

use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;
use Exception;
use Illuminate\Support\Str;
use Spatie\SslCertificate\SslCertificate;

class SslCheck extends Check
{
    protected ?string $domain = null;

    public function domain(
        string $domain,
    ): self {
        $this->domain = $domain;

        return $this;
    }

    private function buildMetaData(
        SslCertificate $certificate,
    ): array {
        return [
            'domain' => $certificate->getDomain(),
            'issuer' => $certificate->getIssuer(),
            'is_valid' => $certificate->isValid(),
            'expiration_date' => $certificate->expirationDate()->diffForHumans(),
            'expiration_date_in_days' => $certificate->expirationDate()->diffInDays(),
        ];
    }

    public function run(): Result
    {
        try {
            $certificate = SslCertificate::createForHostName(
                url: $this->domain
            );

            $meta = $this->buildMetaData(
                certificate: $certificate,
            );

            if (!$certificate->isValid()) {
                return Result::make()
                    ->failed('SSL certificate is invalid')
                    ->shortSummary('Invalid SSL certificate')
                    ->meta($meta);
            }

            return Result::make()
                ->ok()
                ->shortSummary('SSL certificate is valid')
                ->meta($meta);
        } catch (Exception $e) {
            return Result::make()
                ->failed($e->getMessage())
                ->shortSummary('SSL check failed');
        }
    }

    public function getName(): string
    {
        $baseName = class_basename(static::class);

        return Str::of($baseName)
            ->beforeLast('Check')
            ->append('_' . $this->domain)
            ->tostring();
    }
}
