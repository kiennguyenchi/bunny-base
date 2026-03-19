<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PedigreeNode from './PedigreeNode.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    rabbit: Object,
});

function downloadPedigree() {
  router.post(route('rabbits.pedigree.download', { rabbit: props.rabbit.id }))
}
</script>

<template>
    <Head :title="'Pedigree: ' + rabbit.name" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Pedigree Tree: {{ rabbit.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div v-if="$page.props.flash.status" class="mb-4 text-sm font-medium text-green-600">
                    {{ $page.props.flash.status }}
                </div>
                <div class="mb-4 flex gap-4 justify-between">
                    <Link :href="route('rabbits.index')" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                        Back to List
                    </Link>
                    <PrimaryButton @click="downloadPedigree">
                        Download PDF
                    </PrimaryButton>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-center">
                            <PedigreeNode :rabbit="rabbit" :generation="0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
