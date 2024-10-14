<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';
import TableLayout from '@/Layouts/TableLayout.vue';
import CreateButton from '@/Components/CreateButton.vue';
import CancelButton from '@/Components/CancelButton.vue';

const permission = ref({
  name: ''
});

const createPermission = async () => {
  await axios.post('/permissions', permission.value);
  window.location.href = '/permissions';
};

const clearForm = () => {
  permission.value = {
    name: ''
  };
};

const handleCancel = () => {
  console.log('Cancel button clicked'); // Debug log
  if (confirm('Are you sure you want to discard the form?')) {
    clearForm();
    window.location.href = '/permissions';
  }
};

const handleSubmit = async (event) => {
  event.preventDefault(); // Prevent default form submission
  if (confirm('Are you sure you want to create this permission?')) {
    await createPermission(); // Call createInstitution if confirmed
  }
};
</script>

<template>
    <Head title="Permissions"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-white">Permission</h2>
        </template>

    <TableLayout>
        <div class="w-full bg-white">
            <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">Create New Permission</h1>
        
            <form @submit.prevent="createPermission" class="grid grid-cols-1 sm:grid-cols-1 gap-4 p-6">
            <div class="col-span-1 sm:col-span-1">
                <label for="name" class="block font-bold">Permission Name</label>
                <input v-model="permission.name" id="name" class="mt-1 block w-full border border-gray-300 rounded p-2"/>
            </div>

            <div class="col-span-1 sm:col-span-2 flex justify-center space-x-4 mt-4">
             <CreateButton>
                <button type="submit" class="w-full sm:w-auto" @click="handleSubmit" :disabled="!isUnique" >Create</button>
              </CreateButton>

              <CancelButton>
                <button type="button" class="w-full sm:w-auto" @click="handleCancel">Cancel</button>
              </CancelButton>
          </div>
            </form>
         </div>
        </div>
    </TableLayout>
    </AuthenticatedLayout>
</template>