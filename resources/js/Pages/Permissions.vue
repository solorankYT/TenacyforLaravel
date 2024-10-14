<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import TableLayout from '@/Layouts/TableLayout.vue';
import CreateButton from '@/Components/CreateButton.vue';
import EditButton from '@/Components/EditButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';

const props = defineProps({
  permissions: Array,
});

const deleteRole = async (id) => {
  if (confirm('Are you sure you want to delete this permissions?')) {
    await router.delete(`permissions/${id}`);
  }
};
</script>

<template>
  <Head title="Permissions" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-white">Permissions</h2>
    </template>
    
  <TableLayout>
    <div class="w-full bg-white">
      <div class="p-4">

      <CreateButton>
        <a :href="`permissions/create`">
          Create New Permission
        </a>
      </CreateButton>

      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b text-left">Name</th>
              <th class="py-2 px-4 border-b text-left">Guard Name</th>
              <th class="py-2 px-4 border-b text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="permission in permissions" :key="permission.id">
              <td class="py-2 px-4 border-b text-left">{{ permission.name }}</td>
              <td class="py-2 px-4 border-b text-left">{{ permission.guard_name }}</td>
              <td class="py-2 px-4 border-b text-left">

              <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
              <EditButton>
                <a :href="`permissions/${permission.id}/edit`">Edit</a>
              </EditButton>

              <DeleteButton>
                <button @click="deleteRole(permission.id)">Delete</button>
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
