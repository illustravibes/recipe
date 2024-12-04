<script setup lang="ts">
import { AppNavigation, Modal } from '@/Components';
import { router } from '@inertiajs/vue3';
import { PropType, ref } from 'vue';

const showCreateModal = ref(false);
const showDeleteModal = ref(false);

const name = ref<string>('');
const amount = ref<number>();
const unit = ref<string>('');
const selectedIngredientId = ref<number | null>(null);

interface TIngredient {
  id: number;
  name: string;
  amount: number;
  unit: string;
  created_at: string;
  updated_at: string;
}

defineProps({
  ingredients: {
    type: Array as PropType<TIngredient[]>,
    default: () => [],
  },
});

function createIngredient() {
  router.post(
    route('ingredient.store'),
    {
      name: name.value,
      amount: amount.value,
      unit: unit.value,
    },
    {
      onSuccess: () => {
        showCreateModal.value = false;
      },
      onError: (errors: any) => {
        console.error('Error creating ingredient:', errors);
      },
    },
  );
}

function deleteIngredient() {
  if (!selectedIngredientId.value) return;
  router.delete(route('ingredient.destroy', selectedIngredientId.value), {
    onSuccess: () => {
      showDeleteModal.value = false;
      selectedIngredientId.value = null;
    },
    onError: (errors: any) => {
      console.error('Error deleting ingredient:', errors);
    },
  });
}
</script>

<template>
  <AppNavigation>
    <div>
      <div class="header">
        <strong class="header-title">Ingredients</strong>
      </div>
      <div class="collections">
        <div class="flex justify-between px-4 pb-2">
          <div>
            <strong class="text-xl">Ingredient</strong>
            <p>Ingredients Collection</p>
          </div>
          <div>
            <button class="create-btn" @click="showCreateModal = true">
              Create
            </button>
            <Modal :show="showCreateModal" @close="showCreateModal = false">
              <template #default>
                <div class="create-form">
                  <h1 class="mb-4 text-2xl font-bold">New Ingredient</h1>
                  <form @submit.prevent="createIngredient">
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
                          <label for="amount" class="mb-2 block font-medium"
                            >Amount</label
                          >
                          <input
                            type="number"
                            id="amount"
                            v-model="amount"
                            class="w-full rounded border px-3 py-2"
                            required
                          />
                        </div>
                        <div>
                          <label for="unit" class="mb-2 block font-medium"
                            >Unit</label
                          >
                          <input
                            type="text"
                            id="unit"
                            v-model="unit"
                            class="w-full rounded border px-3 py-2"
                            required
                          />
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
                <th class="w-28">Amount</th>
                <th class="w-32">Unit</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(ingredient, index) in ingredients"
                :key="ingredient.id"
              >
                <td>{{ index + 1 }}</td>
                <td>{{ ingredient.name }}</td>
                <td>{{ ingredient.amount }}</td>
                <td>{{ ingredient.unit }}</td>
                <td>{{ ingredient.created_at }}</td>
                <td>{{ ingredient.updated_at }}</td>
                <td>
                  <div class="flex flex-row gap-4">
                    <button
                      class="update-btn"
                      @click="
                        $inertia.get(route('ingredient.update', ingredient.id))
                      "
                    >
                      Update
                    </button>
                    <button
                      class="delete-btn"
                      @click="
                        () => {
                          selectedIngredientId = ingredient.id;
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
            <h1 class="mb-4 text-xl">
              Are you sure to delete this ingredient?
            </h1>
            <div class="flex justify-end space-x-2">
              <button @click="showDeleteModal = false" class="cancel-btn">
                Cancel
              </button>
              <button @click="deleteIngredient" class="delete-btn">
                Delete
              </button>
            </div>
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

.create-form {
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
