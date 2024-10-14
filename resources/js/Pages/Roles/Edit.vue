<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import RoleSelect from '@/Components/RoleSelect.vue'; 
import TableLayout from '@/Layouts/TableLayout.vue';
import UpdateButton from '@/Components/UpdateButton.vue';
import CancelButton from '@/Components/CancelButton.vue';

const props = defineProps({
  role: Object,
  permissions: Array,
  rolePermissions: Array,
});

const role = ref({
  ...props.role,
  permissions: [...props.rolePermissions], // Initialize the permissions with the current ones
});

const updateRole = async () => {
    await router.put(`/admin/usermanagement/roles/${role.value.id}`, {name: role.value.name, permissions: role.value.permissions,});
};

const handleCancel = () => {
  console.log('Cancel button clicked'); // Debug log
  if (confirm('Are you sure you want to discard the form?')) {
  window.location.href = '/admin/usermanagement/roles'; 
  }
};

const handleSubmit = async (event) => {
  event.preventDefault(); // Prevent default form submission
  if (confirm('Are you sure you want to update this role?')) {
    await updateRole(); // Call createInstitution if confirmed
  }
};
</script>

<template>
  <Head title="Edit Role" />
  <AuthenticatedLayout>

    <template #header>
      <h2 class="font-semibold text-white">Role</h2>
    </template>

  <TableLayout>
    <div class="w-full bg-white">
     <div class ="p-4">
      <h1 class="text-2xl font-bold mb-4">Edit Role</h1>

      <form @submit.prevent="updateRole" class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-6">
        <div class="col-span-1 sm:col-span-1">
          <label for="name" class="block font-bold">Role Name</label>
          <input v-model="role.name" id="name" class="mt-1 block w-full border border-gray-300 rounded p-2" required/>
        </div>

        <div class="col-span-1 sm:col-span-1">
          <RoleSelect label="Permissions" :options="permissions" v-model="role.permissions" />
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
