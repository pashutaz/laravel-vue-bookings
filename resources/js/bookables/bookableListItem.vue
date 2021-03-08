<template>
  <div class="card w-100">
    <div class="card-body">
      <h5 class="card-title">
        {{ title }}
      </h5>
      <p class="card-text">{{ content }}</p>
      <p v-if="price">{{ price }}$</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    content: String,
    price: Number,
  },
};
</script>
