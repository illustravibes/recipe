<script lang="ts">
export default {
  name: 'AppNavigation',
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
  <div class="navigation">
    <nav class="sidebar">
      <ul class="navigation-menu">
        <li v-for="(route, index) in navigations" :key="index">
          <a :href="route.to" class="nav-item">{{ route.label }}</a>
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
  @apply flex h-full w-1/5 flex-col space-y-4 border border-zinc-300 p-4;
}

.navigation-menu {
  @apply space-y-2;
}

.nav-item {
  @apply block rounded border border-zinc-200 px-4 py-2 transition duration-300 hover:border-zinc-400 hover:bg-zinc-200;
}

.content {
  @apply flex-1 overflow-y-auto bg-zinc-50;
}
</style>
