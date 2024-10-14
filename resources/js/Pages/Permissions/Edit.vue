<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TableLayout from '@/Layouts/TableLayout.vue';
import UpdateButton from '@/Components/UpdateButton.vue';
import CancelButton from '@/Components/CancelButton.vue';

const props = defineProps({
  permission: Object,
});

const permission = ref({ ...props.permission });

const updatePermission = async () => {
  await router.put(`/permissions/${permission.value.id}`, permission.value);
};

const handleCancel = () => {
  console.log('Cancel button clicked'); // Debug log
  if (confirm('Are you sure you want to discard the form?')) {
  window.location.href = '/permissions'; 
  }
};

const handleSubmit = async (event) => {
  event.preventDefault(); // Prevent default form submission
  if (confirm('Are you sure you want to update this permission?')) {
    await updatePermission(); // Call createInstitution if confirmed
  }
};
</script>

<template>
  <Head title="Edit Permission" />
  <AuthenticatedLayout>

    <template #header>
      <h2 class="font-semibold text-white">Permission</h2>
    </template>

  <TableLayout>
    <div class="w-full bg-white">
     <div class="p-4">
      <h1 class="text-2xl font-bold mb-4">Edit Permission</h1>

      <form @submit.prevent="updatePermission" class="grid grid-cols-1 sm:grid-cols-1 gap-4 p-6">
        <div class="col-span-1 sm:col-span-1">
          <label for="name" class="block font-bold">Permission Name</label>
          <input v-model="permission.name" id="name" class="mt-1 block w-full border border-gray-300 rounded p-2"/>
        </div>
        <div class="col-span-1 sm:col-span-3 flex justify-center space-x-4 mt-4">
          <UpdateButton>
              <button class="w-full sm:w-auto"  @click="handleSubmit">Update</button>
            </UpdateButton>

            <CancelButton>
              <button class="w-full sm:w-auto"  @click="handleCancel">Cancel</button>
            </CancelButton>
          </div>
      </form>
     </div>
    </div>
   </TableLayout>
  </AuthenticatedLayout>
</template>
