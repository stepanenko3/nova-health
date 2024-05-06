<?php

namespace Stepanenko3\NovaHealth\Checks;

use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;
use Illuminate\Support\Facades\Process;
use RuntimeException;

class OutdatedPackagesCheck extends Check
{
    protected int $failWhenOutdatedPackagesIsHigher = 1;

    public function failWhenOutdatedPackagesIsHigher(
        int $failWhenOutdatedPackagesIsHigher,
    ): self {
        $this->failWhenOutdatedPackagesIsHigher = $failWhenOutdatedPackagesIsHigher;

        return $this;
    }

    public function run(): Result
    {
        $result = Process::run('composer outdated -D -f json');

        if ($result->failed()) {
            throw new RuntimeException('Composer outdated failed: ' . $result->errorOutput());
        }

        $json = json_decode(
            json: $result->output(),
            flags: JSON_THROW_ON_ERROR,
        );

        $outdatedCount = count($json?->installed ?? []);

        $result = Result::make()
            ->ok()
            ->shortSummary(
                "Outdated packages: {$outdatedCount}"
            )
            ->meta([
                'outdated' => $json?->installed ?? [],
            ]);

        if ($outdatedCount >= $this->failWhenOutdatedPackagesIsHigher) {
            return $result->failed(
                "There are {$outdatedCount} outdated packages which is higher or equal to the allowed {$this->failWhenOutdatedPackagesIsHigher}",
            );
        }

        return $result;
    }
}
