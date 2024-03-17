<script setup>
import { getToday } from "@/common";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { onMounted, reactive, ref, defineProps, computed } from "vue";
import { inertia, Inertia } from "@inertiajs/inertia";
import MicroModal from "@/Components/MicroModal.vue";
import dayjs from "dayjs";

const props = defineProps({
  items: Array,
  order: Array
});

onMounted(() => {
  console.log(props.items);
  console.log(props.order);
  //ページ読み込み後、即座に実行
});
</script>

<template>
  <Head title="購買履歴 詳細画面" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">購買履歴 詳細画面</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <section class="text-gray-600 body-font relative">
              <form @submit.prevent="storePurchase">
                <div class="container px-5 py-8 mx-auto">
                  <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <div class="flex flex-wrap -m-2">
                      <div class="p-2 w-full">
                        <div class>
                          <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                          <div
                            id="date"
                            name="date"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          >{{ dayjs(props.order[0].created_at).format('YYYY/MM/DD') }}</div>
                        </div>
                      </div>
                      <div class="p-2 w-full">
                        <div class>
                          <label for="name" class="leading-7 text-sm text-gray-600">会員名</label>
                          <div
                            id="date"
                            name="date"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          >{{ props.order[0].customer_name }}</div>
                        </div>
                      </div>
                      <br />
                      <div class="p-2 w-full">
                        <div class>
                          <table
                            class="w-full mt-5 bg-gray-300 bg-opacity-50 rounded focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                          >
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>商品名</th>
                                <th>金額</th>
                                <th>数量</th>
                                <th>小計</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr
                                v-for="item in props.items"
                                class="bg-white border-b border-gray-300"
                              >
                                <td class="text-center">{{ item.item_id }}</td>
                                <td>{{ item.item_name }}</td>
                                <td>{{ item.item_price }}</td>
                                <td>
                                    {{ item.quantity }}
                                </td>
                                <td>{{ item.subtotal }}</td>
                              </tr>
                            </tbody>
                          </table>
                          <br />

                          <div class="p-2 w-full">
                            <div>
                              <label for="name" class="leading-7 text-sm text-gray-600">合計金額</label>
                              <div
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                              >{{ props.order[0].total }} 円</div>
                            </div>
                          </div>

                          <div class="p-2 w-full">
                            <div>
                              <label for="name" class="leading-7 text-sm text-gray-600">ステータス</label>
                              <div
                                v-if="props.order[0].status == true"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                              >未キャンセル</div>
                              <div
                                v-if="props.order[0].status == false"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                              >キャンセル済</div>
                            </div>
                          </div>

                          <div class="p-2 w-full">
                            <div>
                              <label for="name" class="leading-7 text-sm text-gray-600">キャンセル日</label>
                              <div
                                v-if="props.order[0].status == false"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                              >{{ dayjs(props.order[0].update_at).format('YYYY/MM/DD') }}</div>
                            </div>
                          </div>

                          <br />
                        </div>
                      </div>

                      <div v-if="props.order[0].status == true" class="p-2 w-full">
                        <Link
                        as="button"
                        :href="route('purchases.edit', { purchase: props.order[0].id })"
                          class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                        >編集する</Link>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
