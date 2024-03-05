<template>
  <div>
    <button @click="sendMessageToParent">Send Message to Parent</button>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const sendMessageToParent = () => {
  const newMessage = 'Hello from Child!';
  emit('sendMessage', newMessage);
};
</script>
