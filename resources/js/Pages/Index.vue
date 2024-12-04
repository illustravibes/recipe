<script lang="ts">
import { AppNavigation } from '@/Components';
export default {
  name: 'Index',
  components: {
    AppNavigation,
  },
  setup() {
    const navigations = [
      {
        label: 'Dashbord',
        to: '/',
      },
      {
        label: 'Categories',
        to: '/categories',
      },
      {
        label: 'Ingredients',
        to: '/ingredients',
      },
      {
        label: 'Recipe',
        to: '/recipes',
      },
    ];

    return {
      navigations,
    };
  },
};
</script>

<template>
  <AppNavigation>
    <div class="content">
      <div class="header">
        <strong class="header-title">Dashboard</strong>
      </div>
      <div class="body">
        <div v-for="(navigation, index) in navigations" :key="index">
          <router-link :href="navigation.to">
            <div class="card">
              <h1>{{ navigation.label }}</h1>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </AppNavigation>
</template>

<style scoped>
.navigation {
  @apply flex h-screen;
}

.header {
  @apply w-full;
  @apply rounded-md border-2 border-zinc-300 bg-zinc-200 p-2;

  .header-title {
    @apply text-2xl font-bold;
  }
}

.body {
  @apply flex flex-row gap-4 p-8;
  .card {
    @apply w-fit rounded-md border-2 border-zinc-300 bg-white px-4 py-2 font-bold hover:border-zinc-400 hover:bg-zinc-100;
  }
}

.sidebar {
  @apply flex h-full w-1/5 flex-col space-y-4 border border-zinc-300 p-4;
}

.navigation-menu {
  @apply space-y-2;
}

.nav-item {
  @apply block rounded border-2 border-zinc-200 px-4 py-2 transition duration-300 hover:border-zinc-400 hover:bg-zinc-200;
}

.content {
  @apply flex-1 overflow-y-auto bg-zinc-50;
}
</style>
