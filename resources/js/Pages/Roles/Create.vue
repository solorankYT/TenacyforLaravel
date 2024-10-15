  <script setup>
  import { ref } from 'vue';
  import { router } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import RoleSelect from '@/Components/RoleSelect.vue';
  import TableLayout from '@/Layouts/TableLayout.vue';
  import CreateButton from '@/Components/CreateButton.vue';
  import CancelButton from '@/Components/CancelButton.vue';

  const props = defineProps({
    permissions: Array,
  });

  const role = ref({
    name: '',
    permissions: [],
  });

  const errorMessage = ref(null);

  const createRole = async () => {
    errorMessage.value = null; 

    try {
      await router.post('/roles', role.value);
      role.value = { name: '', permissions: [] }; 
    } catch (error) {
      errorMessage.value = error.response?.data?.message || 'Failed to create role';
    }
  };

  const clearForm = () => {
  role.value = {
    name: '',
    permissions: []
  };
};

const handleCancel = () => {
  console.log('Cancel button clicked'); // Debug log
  if (confirm('Are you sure you want to discard the form?')) {
    clearForm();
    window.location.href = '/roles';
  }
};

const handleSubmit = async (event) => {
  event.preventDefault(); // Prevent default form submission
  if (confirm('Are you sure you want to create this role?')) {
    await createRole(); // Call createInstitution if confirmed
  }
};

  </script>

  <template>
    <Head title="Create Role" />

    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-white">Role</h2>
      </template>

    <TableLayout>
      <div class="w-full bg-white">
        <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Create New Role</h1>
        
        <div v-if="errorMessage" class="mb-4 text-red-600">{{ errorMessage }}</div>

        <form @submit.prevent="createRole" class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-6">
          <div class="col-span-1 sm:col-span-1">
            <label for="name" class="block font-bold">Role Name</label>
            <input v-model="role.name" id="name" class="mt-1 block w-full border border-gray-300 rounded p-2" placeholder="Enter Role Name" required/>
          </div>

          <div class="col-span-1 sm:col-span-1">
            <RoleSelect
              label="Permissions"
              :options="permissions"
              v-model="role.permissions"
              multiple
              class="border-none p-0"
            />
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
