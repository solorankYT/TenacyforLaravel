<template>
  <div>
    <label :for="label" class="block font-bold">{{ label }}</label>
    <multiselect
      class ="block w-full border border-gray-300 rounded"
      v-model="selected"
      :options="options"
      :multiple="true"
      :close-on-select="false"
      :clear-on-select="false"
      :preserve-search="true"
      :hide-selected="true"
      placeholder="Begin typing a role to filter..."
      
    />
  </div>
</template>

<script setup>
import { defineProps, ref, watch, defineEmits } from 'vue';
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.min.css';

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  options: {
    type: Array,
    required: true,
  },
  modelValue: {
    type: Array,
    default: () => [],
  },
});

const selected = ref([...props.modelValue]);

// Emit changes to the parent component
const emit = defineEmits(['update:modelValue']);

// Watch for changes to the selected value
watch(selected, (newVal) => {
  emit('update:modelValue', newVal);
});

// Watch for changes to modelValue prop to synchronize selected
watch(() => props.modelValue, (newVal) => {
  if (JSON.stringify(newVal) !== JSON.stringify(selected.value)) {
    selected.value = [...newVal];
  }
}, { immediate: true }); // Use immediate to sync on component mount
</script>
