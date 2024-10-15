<script setup>
import { ref, computed, defineProps, defineEmits } from 'vue';

const props = defineProps({
  roles: Array,
  modelValue: Array,
});

const emit = defineEmits(['update:modelValue']);

const selectedValues = ref([...props.modelValue]);
const isOpen = ref(false);

const selectedItems = computed(() => {
  if (!props.roles) return [];
  return props.roles
    .filter(role => selectedValues.value.includes(role.id))
    .map(role => role.name);
});

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

const handleRoleChange = (roleId) => {
  const index = selectedValues.value.indexOf(roleId);
  if (index > -1) {
    selectedValues.value.splice(index, 1);
  } else {
    selectedValues.value.push(roleId);
  }
  emit('update:modelValue', selectedValues.value);
};

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
  const dropdown = document.querySelector('.dropdown-menu');
  if (dropdown && !dropdown.contains(event.target)) {
    isOpen.value = false;
  }
};

</script>

<template>
  <div class="relative">
    <button @click="toggleDropdown" type="button" class="block w-full bg-gray-200 border border-gray-300 rounded-md p-2 text-left">
  <span v-if="selectedItems.length === 0">Select roles...</span>
  <span v-else>{{ selectedItems.join(', ') }}</span>
  <svg class="absolute right-2 top-1/2 transform -translate-y-1/2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
  </svg>
</button>

    <div v-if="isOpen" class="dropdown-menu absolute w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10">
      <div v-for="role in roles" :key="role.id" class="p-2 hover:bg-gray-100">
        <input
          type="checkbox"
          :id="'role-' + role.id"
          :value="role.id"
          :checked="selectedValues.includes(role.id)"
          @change="handleRoleChange(role.id)"
          class="mr-2"
        />
        <label :for="'role-' + role.id">{{ role.name }}</label>
      </div>
    </div>
  </div>
</template>
