<script setup lang="ts">
import { AppNavigation, Modal } from '@/Components';
import { router } from '@inertiajs/vue3';
import { PropType, ref, watchEffect } from 'vue';

const showCreateModal = ref(false);
const showUpdateModal = ref(false);
const showDeleteModal = ref(false);

const name = ref<string>('');
const description = ref<string>();
const id = ref<number | null>(null);
const category_id = ref<number | null>(null);
const selectedIngredients = ref<number[]>([]);

interface TIngredient {
  id: number;
  name: string;
  amount: number;
  unit: string;
}

interface TCategory {
  id: number;
  name: string;
}

interface TRecipe {
  id: number;
  name: string;
  description: string | null;
  category: TCategory;
  ingredients: TIngredient[];
  created_at: string;
  updated_at: string;
}

defineProps({
  recipes: {
    type: Array as PropType<TRecipe[]>,
    default: () => [],
  },
  categories: {
    type: Array as PropType<{ id: number; name: string }[]>,
    default: () => [],
  },
  ingredients: {
    type: Array as PropType<
      { id: number; name: string; amount: number; unit: string }[]
    >,
    default: () => [],
  },
});
watchEffect(() => {
  console.log(category_id.value);
  console.log(selectedIngredients.value);
});

function createRecipe() {
  router.post(
    route('recipe.store'),
    {
      name: name.value,
      description: description.value,
      category_id: category_id.value,
      ingredients: selectedIngredients.value,
    },
    {
      onSuccess: () => {
        showCreateModal.value = false;
        name.value = '';
        description.value = '';
        category_id.value = null;
        selectedIngredients.value = [];
      },
      onError: (errors: any) => {
        console.error('Error creating recipe:', errors);
      },
    },
  );
}

function updateRecipe() {
  if (!id.value) return;

  router.put(
    route('recipe.update', id.value),
    {
      name: name.value,
      description: description.value,
      category_id: category_id.value,
      ingredients: selectedIngredients.value,
    },
    {
      onSuccess: () => {
        showUpdateModal.value = false;
        id.value = null;
        name.value = '';
        description.value = '';
        category_id.value = null;
        selectedIngredients.value = [];
      },
      onError: (errors: any) => {
        console.error('Error updating recipe:', errors);
      },
    },
  );
}

function prepareUpdateModal(recipe: TRecipe) {
  id.value = recipe.id;
  name.value = recipe.name;
  description.value = recipe.description || '';
  category_id.value = recipe.category.id;
  selectedIngredients.value = recipe.ingredients.map((ing) => ing.id);
  showUpdateModal.value = true;
}

function deleteRecipe() {
  if (!id.value) return;
  router.delete(route('recipe.destroy', id.value), {
    onSuccess: () => {
      showDeleteModal.value = false;
      id.value = null;
    },
    onError: (errors: any) => {
      console.error('Error deleting recipe:', errors);
    },
  });
}
</script>

<template>
  <AppNavigation>
    <div>
      <div class="header">
        <strong class="header-title">Recipes</strong>
      </div>
      <div class="collections">
        <div class="flex justify-between px-4 pb-2">
          <div>
            <strong class="text-xl">Recipe</strong>
            <p>Recipes Collection</p>
          </div>
          <div>
            <button class="create-btn" @click="showCreateModal = true">
              Create
            </button>
            <Modal :show="showCreateModal" @close="showCreateModal = false">
              <template #default>
                <div class="form">
                  <h1 class="mb-4 text-2xl font-bold">New Recipe</h1>
                  <form @submit.prevent="createRecipe">
                    <div class="flex flex-col gap-8">
                      <div class="flex flex-col gap-4">
                        <div>
                          <label for="name" class="mb-2 block font-medium"
                            >Name</label
                          >
                          <input
                            type="text"
                            id="name"
                            v-model="name"
                            class="w-full rounded border px-3 py-2"
                            required
                          />
                        </div>
                        <div>
                          <label
                            for="description"
                            class="mb-2 block font-medium"
                            >Description</label
                          >
                          <input
                            type="text"
                            id="decription"
                            cols="40"
                            rows="5"
                            v-model="description"
                            class="w-full rounded border px-3 py-2"
                            required
                          />
                        </div>
                        <div>
                          <label
                            class="mb-2 block font-medium"
                            for="category_id"
                            >Category</label
                          >
                          <select
                            class="w-full rounded border px-3 py-2"
                            id="category_id"
                            v-model="category_id"
                          >
                            <option
                              v-for="category in categories"
                              :value="category.id"
                              :key="category.id"
                            >
                              {{ category.name }}
                            </option>
                          </select>
                        </div>
                        <div>
                          <label>Ingredients: </label>
                          <div
                            v-for="ingredient in ingredients"
                            :key="ingredient.id"
                          >
                            <input
                              type="checkbox"
                              :value="ingredient.id"
                              v-model="selectedIngredients"
                            />
                            <label>{{
                              `${ingredient.name} ${ingredient.amount} ${ingredient.unit}`
                            }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="flex justify-end space-x-2">
                        <button
                          type="button"
                          @click="showCreateModal = false"
                          class="cancel-btn"
                        >
                          Cancel
                        </button>
                        <button type="submit" class="create-btn">Save</button>
                      </div>
                    </div>
                  </form>
                </div>
              </template>
            </Modal>
          </div>
        </div>
        <div class="table">
          <table>
            <thead>
              <tr>
                <th class="w-10">No</th>
                <th>Name</th>
                <th class="w-40">Description</th>
                <th class="w-32">Category</th>
                <th>Recipe</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(recipe, index) in recipes" :key="recipe.id">
                <td>{{ index + 1 }}</td>
                <td>{{ recipe.name }}</td>
                <td>{{ recipe.description }}</td>
                <td>{{ recipe.category ? recipe.name : '-' }}</td>
                <td>
                  <ul>
                    <li
                      v-for="ingredient in recipe.ingredients"
                      :key="ingredient.id"
                    >
                      {{
                        ` - ${ingredient.name} ${ingredient.amount} ${ingredient.unit}`
                      }}
                    </li>
                  </ul>
                </td>
                <td>
                  <div class="flex flex-row gap-4">
                    <button
                      class="update-btn"
                      @click="prepareUpdateModal(recipe)"
                    >
                      Update
                    </button>
                    <button
                      class="delete-btn"
                      @click="
                        () => {
                          id = recipe.id;
                          showDeleteModal = true;
                        }
                      "
                    >
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <Modal
        class="m-0"
        :show="showDeleteModal"
        @close="showDeleteModal = false"
      >
        <template #default>
          <div class="p-8">
            <h1 class="mb-4 text-xl">Are you sure to delete this recipe?</h1>
            <div class="flex justify-end space-x-2">
              <button @click="showDeleteModal = false" class="cancel-btn">
                Cancel
              </button>
              <button @click="deleteRecipe" class="delete-btn">Delete</button>
            </div>
          </div>
        </template>
      </Modal>

      <Modal :show="showUpdateModal" @close="showUpdateModal = false">
        <template #default>
          <div class="form">
            <h1 class="mb-4 text-2xl font-bold">New Recipe</h1>
            <form @submit.prevent="updateRecipe">
              <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-4">
                  <div>
                    <label for="name" class="mb-2 block font-medium"
                      >Name</label
                    >
                    <input
                      type="text"
                      id="name"
                      v-model="name"
                      class="w-full rounded border px-3 py-2"
                      required
                    />
                  </div>
                  <div>
                    <label for="description" class="mb-2 block font-medium"
                      >Description</label
                    >
                    <input
                      type="text"
                      id="decription"
                      cols="40"
                      rows="5"
                      v-model="description"
                      class="w-full rounded border px-3 py-2"
                      required
                    />
                  </div>
                  <div>
                    <label class="mb-2 block font-medium" for="category_id"
                      >Category</label
                    >
                    <select
                      class="w-full rounded border px-3 py-2"
                      id="category_id"
                      v-model="category_id"
                    >
                      <option
                        v-for="category in categories"
                        :value="category.id"
                        :key="category.id"
                      >
                        {{ category.name }}
                      </option>
                    </select>
                  </div>
                  <div>
                    <label>Ingredients: </label>
                    <div v-for="ingredient in ingredients" :key="ingredient.id">
                      <input
                        type="checkbox"
                        :value="ingredient.id"
                        v-model="selectedIngredients"
                      />
                      <label>{{
                        `${ingredient.name} ${ingredient.amount} ${ingredient.unit}`
                      }}</label>
                    </div>
                  </div>
                </div>
                <div class="flex justify-end space-x-2">
                  <button
                    type="button"
                    @click="showUpdateModal = false"
                    class="cancel-btn"
                  >
                    Cancel
                  </button>
                  <button type="submit" class="create-btn">Save</button>
                </div>
              </div>
            </form>
          </div>
        </template>
      </Modal>
    </div>
  </AppNavigation>
</template>

<style scoped>
.header {
  @apply w-full;
  @apply rounded-md border-2 border-zinc-300 bg-zinc-200 p-2;

  .header-title {
    @apply text-2xl font-bold;
  }
}
.collections {
  @apply p-8;
}

.table {
  @apply w-full;
}

.form {
  @apply p-8;
}

.create-btn {
  @apply rounded-md border bg-green-600 px-4 py-1 font-bold text-white;
}

.update-btn {
  @apply rounded-md border bg-blue-600 px-4 py-1 font-bold text-white;
}
.delete-btn {
  @apply rounded-md border bg-red-600 px-4 py-1 font-bold text-white;
}

.cancel-btn {
  @apply rounded bg-gray-300 px-4 py-2 font-bold;
}

table {
  @apply w-full;
  @apply m-0;
  @apply table-fixed border-collapse;
  @apply border-2 border-zinc-300;
  @apply break-inside-auto;

  tr {
    @apply break-inside-avoid break-after-auto;

    &:nth-child(even) {
      @apply bg-zinc-100;
    }
  }

  thead {
    @apply table-header-group;
    @apply bg-zinc-200;
  }

  tfoot {
    @apply table-footer-group;
    @apply bg-zinc-100;
  }

  th {
    @apply border border-zinc-300 p-2;
    @apply text-left font-bold;
    @apply uppercase tracking-wider;

    &.subject {
      @apply text-left;
    }
  }

  td {
    @apply border border-zinc-300 p-2;
    @apply align-middle;

    &.subject {
      @apply text-left font-medium;
    }
  }
}
</style>
