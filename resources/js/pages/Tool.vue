<template>
    <div class="nova-health">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xl">
                {{ __("Health") }}
            </span>

            <span v-if="finishedAt" class="text-sm text-gray-400 ml-4">
                {{ finishedAt }}
            </span>

            <div
                class="ml-auto shadow-lg bg-white dark:bg-gray-800 cursor-pointer w-8 h-8 flex items-center justify-center rounded-lg hover:opacity-75 transition"
                :disabled="loading"
                :loading="loading"
                @click="refresh"
            >
                <Icon type="refresh" class="w-4 h-4" />
            </div>
        </div>

        <div
            class="absolute flex items-center justify-center inset-0 bg-white/50 dark:bg-gray-900/80 z-20"
            :class="{
                'opacity-0  pointer-events-none': !loading,
                'relative min-h-[200px] bg-transparent': checks.length <= 0,
            }"
        >
            <div
                class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] text-primary-500 motion-reduce:animate-[spin_1.5s_linear_infinite]"
                role="status"
            ></div>
        </div>

        <div class="grid md:grid-cols-12 gap-6" v-if="checks.length">
            <div
                class="md:col-span-4 h-full p-6 flex items-start relative overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow md:col-span-4"
                v-for="check in checks"
            >
                <Icon
                    width="30"
                    height="30"
                    class="mr-4 flex-shrink-0"
                    :class="
                        getByStatus(check.status, {
                            ok: 'text-green-500',
                            warning: 'text-yellow-500',
                            skipped: 'text-blue-500',
                            failed: 'text-red-500',
                            crashed: 'text-red-500',
                            default: 'text-gray-500',
                        })
                    "
                    :type="
                        getByStatus(check.status, {
                            ok: 'check-circle',
                            warning: 'exclamation-circle',
                            skipped: 'arrow-circle-right',
                            failed: 'x-circle',
                            crashed: 'exclamation-circle',
                            default: 'dots-circle-horizontal',
                        })
                    "
                />

                <div>
                    <div class="text-lg">
                        {{ check.label }}
                    </div>
                    <div class="text-sm mt-2">
                        {{ check.notificationMessage || check.shortSummary }}
                    </div>

                    <div
                        v-if="
                            check.name === 'OutdatedPackages' &&
                            check?.meta?.outdated
                        "
                        class="mt-3 grid gap-1"
                    >
                        <div v-for="pkg of check.meta.outdated">
                            <span
                                class="inline-block font-bold text-gray-500 mr-1"
                            >
                                {{ pkg.name }}
                            </span>
                            <span>{{ pkg.version }} -> {{ pkg.latest }}</span>
                        </div>
                    </div>
                    <div
                        v-else-if="check.name === 'CpuLoad'"
                        class="mt-3 grid gap-1 text-gray-400"
                    >
                        <div>
                            Last minute:
                            <span class="font-bold text-gray-500">
                                {{ check.meta.last_minute }}%</span
                            >
                        </div>
                        <div>
                            Last 5 minutes:
                            <span class="font-bold text-gray-500">
                                {{ check.meta.last_5_minutes }}%</span
                            >
                        </div>
                        <div>
                            Last 15 minutes:
                            <span class="font-bold text-gray-500">
                                {{ check.meta.last_15_minutes }}%</span
                            >
                        </div>
                    </div>
                    <div
                        v-else-if="check.name === 'DatabaseTableSize'"
                        class="mt-3 grid gap-1"
                    >
                        <div v-for="table of Object.values(check.meta)">
                            <div>
                                <span class="font-bold text-gray-500 mr-1">
                                    {{ table.name }}
                                </span>
                                <span>
                                    used {{ table.actualSize }}
                                    of
                                    {{ table.maxSize }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { defineProps, onMounted, ref } from "vue";
import { useLocalization } from "LaravelNova";

defineProps<{
    card: {
        title: string;
        polling?: boolean;
        refresh?: boolean;
    };
}>();

const { __ } = useLocalization();

const loading = ref<boolean>(false);
const checks = ref<any[]>([]);
const finishedAt = ref<string | null>(null);

type CheckResultTypeMeta = {
    outdated?: {
        name: string;
        version: string;
        latest: string;
    }[];
    last_minute?: number;
    last_5_minutes?: number;
    last_15_minutes?: number;
    [key: string]: any;
};

type CheckResultType = {
    label: string;
    name: string;
    status: string;
    shortSummary: string;
    notificationMessage: string;
    meta: CheckResultTypeMeta;
};

type NovaHealthResponseType = {
    checkResults: CheckResultType[];
    finishedAt: number;
};

async function refresh() {
    loading.value = true;

    await fetch("/nova-vendor/stepanenko3/nova-health")
        .then((res) => res.json())
        .then((data: NovaHealthResponseType) => {
            checks.value = data.checkResults;

            const d = new Date(data.finishedAt * 1000);
            const dateString =
                ("0" + d.getDate()).slice(-2) +
                "/" +
                ("0" + (d.getMonth() + 1)).slice(-2) +
                "/" +
                d.getFullYear() +
                " " +
                ("0" + d.getHours()).slice(-2) +
                ":" +
                ("0" + d.getMinutes()).slice(-2);

            finishedAt.value = dateString;
        })
        .catch((error) => {
            console.error("Error fetching health:", error);
        });

    loading.value = false;
}

onMounted(() => {
    refresh();
});

function getByStatus(status, data) {
    if (data.hasOwnProperty(status)) {
        return data[status];
    }

    return data.default;
}
</script>
