<template>
  <div class="card w-100">
    <div class="card-body">
      <router-link :to="{ name: 'bookable.show', params: {id} }">
        <h5 class="card-title">{{ title }}</h5>
      </router-link>
      <p class="card-text">{{ description }}</p>
      <p v-if="id">{{ id }}$</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    description: String,
    id: Number,
  },
};
</script>
