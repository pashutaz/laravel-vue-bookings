<template>
  <div class="card w-100">
    <router-link :to="{ name: 'bookable.show', params: {id} }">
      <div class="card-header">
        <h5 class="card-title">{{ title }}</h5>
      </div>
    </router-link>
    <img :src="`https://picsum.photos/seed/${ title }/300/200`" alt="">
    <div class="card-body">
      <p class="card-text">{{ description }}</p>
      <p v-if="price">From ${{ price }}/d</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    description: String,
    id: Number,
    price: Number
  },
};
</script>
