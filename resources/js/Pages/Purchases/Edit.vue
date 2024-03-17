<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { onMounted, reactive, ref, defineProps, computed } from "vue";
import { inertia, Inertia } from "@inertiajs/inertia";
import dayjs from 'dayjs';

const props = defineProps({
    'order': Array,
    'items': Array
});

const itemList = ref([]);

onMounted(() => {
  //ページ読み込み後、即座に実行
  console.log(props.items);
  props.items.forEach(item => {
    itemList.value.push({
      id: item.id,
      name: item.name,
      price: item.price,
      quantity: item.quantity
    });
  });
});

const totalPrice = computed(() => {
  let total = 0;
  itemList.value.forEach(item => {
    total += item.price * item.quantity;
  });
  return total;
});

const updatePurchase = id => {
  itemList.value.forEach(item => {
    if (item.quantity > 0) {
      form.items.push({
        id: item.id,
        quantity: item.quantity
      });
    }
  });
  Inertia.put(route("purchases.update", { purchase: id }), form);
};

const quantity = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

const form = reactive({
  id: props.order[0].id,
  date: dayjs(props.order[0].created_at).format('YYYY/MM/DD'),
  customer_id: props.order[0].customer_id,
  status: props.order[0].status,
  items: []
});

</script>

<template>
  <Head title="購買履歴 編集画面" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">購買履歴 編集画面</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <section class="text-gray-600 body-font relative">
              <form @submit.prevent="updatePurchase(form.id)">
                <div class="container px-5 py-8 mx-auto">
                  <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <div class="flex flex-wrap -m-2">
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                          <div
                            id="date"
                            name="date"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          >{{ form.date }}</div>
                        </div>
                      </div>
                      <div class="p-2 w-full">
                          <label for="name" class="leading-7 text-sm text-gray-600">会員名</label>
                        <div
                            id="customer"
                            name="customer"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          >{{ props.order[0].customer_name }}</div>
                      </div>

                      <br />
                      <div class="p-2 w-full">

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
                                v-for="item in itemList"
                                class="bg-white border-b border-gray-300"
                              >
                                <td class="text-center">{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.price }}</td>
                                <td class="flex justify-center">
                                  <select name="quantity" v-model="item.quantity">
                                    <option v-for="q in quantity" :value="q">{{ q }}</option>
                                  </select>
                                </td>
                                <td>{{ item.price * item.quantity }}</td>
                              </tr>
                            </tbody>
                          </table>
                      </div>
                          <br />
                        <div class="p-2 w-full">
                          <label for="name" class="leading-7 text-sm text-gray-600">合計金額</label>
                          <div
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          >{{ totalPrice }} 円</div>
                          <br />
                        </div>

                        <div class="p-2 w-full">
                          <label for="stautus" class="leading-7 text-sm text-gray-600">ステータス</label>
                        <input
                            type="radio"
                            id="status"
                            v-model="form.status"
                            name="status"
                            value="1"
                          >未キャンセル</input>
                        <input
                            type="radio"
                            id="status"
                            v-model="form.status"
                            name="sutus"
                            value="0"
                          >キャンセルする</input>
                      </div>

                      <div class="p-2 w-full">
                        <button
                          class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                        >更新する</button>
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
