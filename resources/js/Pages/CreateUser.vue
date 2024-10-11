<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';
import RoleSelect from '@/Components/RoleSelect.vue';
import TableLayout from '@/Layouts/TableLayout.vue';
import CreateButton from '@/Components/CreateButton.vue';
import CancelButton from '@/Components/CancelButton.vue';
import axios from 'axios'; // Import axios for API calls

const props = defineProps({
  roles: Array,
  username: Array,
  email: Array,
  personData: Array,
  institutions: Array // Add institutions as a prop
});

const form = ref({
  edupid: '',
  username: '',
  email: '',
  password: '',
  password_confirmation: '',
  roles: [],
  institution_id: '', // Add institution_id
});

const errors = ref({});
const isUniqueUsername = ref(false);
const isUniqueEmail = ref(false);

// Validate username and email as before...

const createUser = async () => {
  try {
    await router.post('/admin/usermanagement/users', form.value);
    clearForm(); // Clear the form after successful submission
  } catch (error) {
    // Handle errors from the server (e.g., validation)
    errors.value = error.response.data.errors || {};
  }
};

// Clear form function...

const handleCancel = () => {
  if (confirm('Are you sure you want to discard the form?')) {
    clearForm();
    window.location.href = '/admin/usermanagement/users';
  }
};

onMounted(async () => {
  // Fetch institutions when component mounts
  try {
    const response = await axios.get('/api/institutions'); // Adjust the endpoint as necessary
    props.institutions = response.data; // Set institutions prop to the fetched data
  } catch (error) {
    console.error('Error fetching institutions:', error);
  }
});
</script>

<template>
  <Head title="Create User" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-white">User Account</h2>
    </template>

    <TableLayout>
      <div class="w-full bg-white">
        <div class="p-4">
          <h1 class="text-2xl font-bold mb-4">Create New User</h1>

          <form @submit.prevent="createUser" class="grid grid-cols-1 sm:grid-cols-4 gap-4 p-6">
            <!-- Other input fields... -->

            <div class="col-span-1 sm:col-span-1 mb-4">
              <label for="institution_id" class="block font-bold">Institution</label>
              <select v-model="form.institution_id" id="institution_id" class="mt-1 block w-full border border-gray-300 rounded p-2" required>
                <option value="">Select an Institution</option>
                <option v-for="institution in props.institutions" :key="institution.id" :value="institution.id">
                  {{ institution.name }} <!-- Adjust according to your institution model -->
                </option>
              </select>
              <span v-if="errors.institution_id" class="text-red-500">{{ errors.institution_id }}</span>
            </div>

            <div class="col-span-1 sm:col-span-4 flex justify-center space-x-4 mt-4">
              <CreateButton>
                <button type="submit" class="w-full sm:w-auto" :disabled="!isUniqueUsername || !isUniqueEmail">Create</button>
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
