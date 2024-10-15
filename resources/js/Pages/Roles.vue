<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import CreateButton from '@/Components/CreateButton.vue';
import EditButton from '@/Components/EditButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';
import TableLayout from '@/Layouts/TableLayout.vue';

const props = defineProps({
  roles: Array, 
  userPermissions: Array,
});

const deleteRole = async (id) => {
  if (confirm('Are you sure you want to delete this role?')) {
    await router.delete(`/roles/${id}`);
  }
};
</script>

<template>
  <Head title="Roles" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-white">Roles</h2>
    </template>
  
  <TableLayout>
    <div class="w-full bg-white">
      <div class="p-4">

      <CreateButton>
        <a :href="`/roles/create`">
          Create New Role
        </a>
      </CreateButton>

      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b text-left">Name</th>
              <th class="py-2 px-4 border-b text-left">Permissions</th>
              <th class="py-2 px-4 border-b text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="role in roles" :key="role.id">
              <td class="py-2 px-4 border-b text-left">{{ role.name }}</td>

              <td class="py-2 px-4 border-b text-left">
                <span v-if="role.permissions && role.permissions.length">
                  {{ role.permissions.map(permission => permission.name).join(', ') }}
                </span>
                <span v-else>No permissions assigned</span>
              </td>
              <td class="py-2 px-4 border-b text-left">

              <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
              <EditButton>
                <a :href="`/roles/${role.id}/edit`">Edit</a>
              </EditButton>

              <DeleteButton>
                <button @click="deleteRole(role.id)">Delete</button>
              </DeleteButton>
              </div>
              </td>
            </tr>
          </tbody>
        </table>
       </div>
      </div>
     </div>
   </TableLayout>
  </AuthenticatedLayout>
</template>
