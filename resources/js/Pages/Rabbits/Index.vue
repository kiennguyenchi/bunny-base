<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ rabbits: Object });
</script>

<template>
  <Head title="My Herd" />
  <AuthenticatedLayout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Rabbit Herd of tenant {{ $page.props.auth.tenant_name }}</h2>
        <Link href="/rabbits/create" class="bg-emerald-600 text-white px-4 py-2 rounded">Add Rabbit</Link>
      </div>

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tattoo/Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sex</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ancestry</th>
              <th class="px-6 py-3"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="rabbit in rabbits.data" :key="rabbit.id">
              <td class="px-6 py-4">
                <div class="font-bold">{{ rabbit.name }}</div>
                <div class="text-sm text-gray-500">#{{ rabbit.tattoo_id }}</div>
              </td>
              <td class="px-6 py-4 capitalize">{{ rabbit.sex }}</td>
              <td class="px-6 py-4 text-sm text-gray-400">
                S: {{ rabbit.sire?.name || 'Unknown' }} | D: {{ rabbit.dam?.name || 'Unknown' }}
              </td>
              <td class="px-6 py-4 text-right">
                <Link :href="`/rabbits/${rabbit.id}`" class="text-indigo-600 hover:text-indigo-900">View Pedigree</Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="mt-6 flex justify-center">
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <template v-for="(link, k) in rabbits.links" :key="k">
                    <div v-if="link.url === null"
                        class="px-4 py-2 text-sm leading-4 text-gray-400 border rounded"
                        v-html="link.label"
                    />

                    <Link v-else
                        :href="link.url"
                        class="px-4 py-2 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                        :class="{ 'bg-blue-600 text-white': link.active }"
                        v-html="link.label"
                    />
                </template>
            </nav>
        </div>
    </div>
  </AuthenticatedLayout>
</template>
