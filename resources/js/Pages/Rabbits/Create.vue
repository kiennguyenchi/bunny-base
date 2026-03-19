<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({ bucks: Array, does: Array });

const form = useForm({
    name: '',
    tattoo_id: '',
    sex: 'doe',
    sire_id: null,
    dam_id: null,
});

const submit = () => {
    form.post(route('rabbits.store'));
};
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <form @submit.prevent="submit" class="w-full max-w-md p-6 bg-white shadow-lg rounded-lg space-y-4">
      <div>
          <InputLabel for="name">
              Rabbit Name <span class="text-red-500">*</span>
          </InputLabel>

          <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
          />

          <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <InputLabel for="sex">
            Sex <span class="text-red-500">*</span>
          </InputLabel>
          <select id="sex" v-model="form.sex" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            <option value="buck">Buck (Male)</option>
            <option value="doe">Doe (Female)</option>
          </select>
          <InputError class="mt-2" :message="form.errors.sex" />
        </div>
        <div>
          <InputLabel for="tattoo_id">
            Tattoo ID <span class="text-red-500">*</span>
          </InputLabel>
          <TextInput
              id="tattoo_id"
              type="text"
              class="mt-1 block w-full"
              v-model="form.tattoo_id"
              required
          />
          <InputError class="mt-2" :message="form.errors.tattoo_id" />
        </div>
      </div>

      <div>
        <InputLabel for="sire_id" value="Sire (Father)" />
        <select id="sire_id" v-model="form.sire_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          <option :value="null">None</option>
          <option v-for="buck in bucks" :key="buck.id" :value="buck.id">{{ buck.name }}</option>
        </select>
        <InputError class="mt-2" :message="form.errors.sire_id" />
      </div>

      <div>
        <InputLabel for="dam_id" value="Dam (Mother)" />
        <select id="dam_id" v-model="form.dam_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          <option :value="null">None</option>
          <option v-for="doe in does" :key="doe.id" :value="doe.id">{{ doe.name }}</option>
        </select>
        <InputError class="mt-2" :message="form.errors.dam_id" />
      </div>

      <div class="flex items-center justify-end gap-4 pt-4">
        <Link
            :href="route('rabbits.index')"
            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25"
        >
            Cancel
        </Link>
        <PrimaryButton :disabled="form.processing">
            {{ form.processing ? 'Saving...' : 'Register Rabbit' }}
        </PrimaryButton>
      </div>
    </form>
  </div>
</template>
