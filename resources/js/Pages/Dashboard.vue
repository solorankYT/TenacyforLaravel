<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                    <div class="p-6 text-gray-900">
                        Institution: {{ typeof institution === 'string' ? institution : institution.name }}
                    </div>
                    <div v-if="institution === 'Super Admin'">
                        <p>Access to all institutions:</p>
                        <ul>
                            <li v-for="inst in allInstitutions" :key="inst.id">{{ inst.name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

defineProps({
    institution: [Object, String], 
    allInstitutions: Array, 
});
</script>
