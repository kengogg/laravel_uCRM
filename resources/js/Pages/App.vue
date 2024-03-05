<template>
  <GuestLayout>
  <div>
    <p>{{ message }}</p>
    <ChildComponent @sendMessage="updateMessage" />
  </div>
</GuestLayout>
</template>

<script setup>
import { ref } from 'vue';
import ChildComponent from '@/Component/ChildComponent.vue';
import GuestLayout from "@/Layouts/GuestLayout.vue";

const message = ref('');

const updateMessage = (newMessage) => {
  message.value = newMessage;
};
</script>
