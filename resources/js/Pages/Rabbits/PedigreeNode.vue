<script setup>
const props = defineProps({
    rabbit: Object,
    generation: { type: Number, default: 0 },
    maxDepth: { type: Number, default: 2 } // 2 means Grandparents (3 total gens)
});
</script>

<template>
  <div class="flex flex-col items-center">
    <div
      :class="[
        'p-3 border-2 rounded-lg w-48 text-center shadow transition-all',
        generation === 0 ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200 bg-white'
      ]"
    >
      <p class="text-[10px] font-bold uppercase text-gray-500">
        {{ generation === 0 ? 'Subject' : (rabbit?.sex === 'buck' ? 'Sire' : 'Dam') }}
      </p>
      <p class="font-bold truncate text-sm">{{ rabbit?.name || 'Unknown' }}</p>
      <p class="text-[10px] text-gray-400">{{ rabbit?.tattoo_id || '---' }}</p>
    </div>

    <div
      v-if="generation < maxDepth && (rabbit?.sire || rabbit?.dam)"
      class="flex mt-8 space-x-4"
    >
      <PedigreeNode
        :rabbit="rabbit?.sire"
        :generation="generation + 1"
        :max-depth="maxDepth"
      />
      <PedigreeNode
        :rabbit="rabbit?.dam"
        :generation="generation + 1"
        :max-depth="maxDepth"
      />
    </div>
  </div>
</template>
