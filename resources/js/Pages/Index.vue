<script class="ts">
import { AppNavigation } from '@/Components'
</script>

<template>
  <AppNavigation>
    <div class="dashboard">
    <div class="header">
      <strong class="header-title">Dashboard</strong>
    </div>
  </div>
  </AppNavigation>
</template>
  

  <style scoped>
  .dashboard {
    .header {
    @apply w-full;
    @apply bg-zinc-200 border-2 border-zinc-300 p-2 rounded-md;
    
    .header-title {
        @apply text-2xl font-bold;
    }
}
  }
  </style>
  