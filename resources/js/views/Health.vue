<template>
    <Heading :level="1" class="flex items-center justify-between mb-6">
        <span>
            {{ __('Health') }}
        </span>

        <span
            v-if="finishedAt"
            class="text-base ml-4"
        >
            {{ finishedAt }}
        </span>

        <LoadingButton
            class="relative ml-auto"
            size="xs"
            component="LinkButton"
            :disabled="loading"
            :loading="loading"
            @click="load"
        >
            <Icon type="refresh" />
        </LoadingButton>
    </Heading>

    <Loader v-if="loading" />

    <div
        class="grid md:grid-cols-12 gap-6"
        v-if="!loading && checks.length"
    >
        <Card
            class="md:col-span-4 h-full p-6 flex items-start"
            v-for="check in checks"
        >
            <Icon
                width="30"
                height="30"
                class="mr-4 flex-shrink-0"
                :class="getByStatus(check.status, {
                    ok: 'text-green-500',
                    warning: 'text-yellow-500',
                    skipped: 'text-blue-500',
                    failed: 'text-red-500',
                    crashed: 'text-red-500',
                    default: 'text-gray-500',
                })"
                :type="getByStatus(check.status, {
                    ok: 'check-circle',
                    warning: 'exclamation-circle',
                    skipped: 'arrow-circle-right',
                    failed: 'x-circle',
                    crashed: 'x-circle',
                    default: 'dots-circle-horizontal',
                })"
            />

            <div>
                <Heading
                    level="3"
                    v-text="check.label"
                />
                <div class="text-sm mt-2">
                    {{ check.notificationMessage || check.shortSummary }}
                </div>
            </div>
        </Card>
    </div>
</template>

<script>
    export default {
        data: () => ({
            loading: true,
            checks: [],
            finishedAt: null,
        }),

        mounted() {
            this.load();
        },

        methods: {
            load() {
                this.loading = true;
                Nova.request().get('/nova-vendor/stepanenko3/nova-health')
                    .then(response => {
                        if (response.status && response.data) {
                            this.loading = false;
                            this.checks = response.data.checkResults;

                            const d = new Date(response.data.finishedAt * 1000);
                            const dateString =
                                ("0" + d.getDate()).slice(-2)
                                + "/" + ("0" + (d.getMonth() + 1)).slice(-2)
                                + "/" + d.getFullYear()
                                + " "
                                + ("0" + d.getHours()).slice(-2)
                                + ":" + ("0" + d.getMinutes()).slice(-2);

                            this.finishedAt = dateString;
                        } else {
                            Nova.error('Error');
                        }
                    });
            },

            getByStatus(status, data) {
                if (data.hasOwnProperty(status)) {
                    return data[status];
                }

                return data.default;
            }
        },
    }
</script>
