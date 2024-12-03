<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'AppNavigation',
});
</script>

<template>
    <div class="navigation">
      <nav class="sidebar">
        <ul class="navigation-menu">
          <li>
            <a href="/" class="nav-item">Dashboard</a>
          </li>
          <li>
            <a href="/categories" class="nav-item">Categories</a>
          </li>
          <li>
            <a href="/ingredients" class="nav-item">Ingredients</a>
          </li>
          <li>
            <a href="/settings" class="nav-item">Settings</a>
          </li>
        </ul>
      </nav>
  
      <!-- Main Content -->
      <main class="content">
        <slot />
      </main>
    </div>
  </template>
  

  <style scoped>
  .navigation {
    @apply flex h-screen;
  }
  
  .sidebar {
    @apply w-1/5 border border-zinc-300 h-full flex flex-col p-4 space-y-4;
  }
  
  .navigation-menu {
    @apply space-y-2;
  }
  
  .nav-item {
    @apply block py-2 px-4 rounded border border-zinc-200 hover:border-zinc-400 hover:bg-zinc-200 transition duration-300;
  }
  
  .content {
    @apply flex-1 bg-zinc-50 overflow-y-auto;
  }
  </style>
  