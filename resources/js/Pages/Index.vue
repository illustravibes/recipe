<script class="ts">
import Navigation from '@/Components/Navigation.vue';
</script>

<template>
  <Navigation>
  <div class="dashboard">
    <div class="header">
      <strong class="header-title">Categories</strong>
    </div>
  </div>
</Navigation>
</template>
  

  <style scoped>
  .dashboard {
    .header {
    @apply w-full;
    @apply bg-zinc-200 border-2 border-zinc-300 p-4 rounded-md;
    
    .header-title {
        @apply text-2xl font-bold;
    }
}
  }
  </style>
  