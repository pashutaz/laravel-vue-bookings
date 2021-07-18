<template>
  <div class="container text-center success">
    <i class="far fa-thumbs-up"></i>
    <h1 class="mt-4">
      <slot>Everything went according to our plan</slot>
    </h1>
  </div>
</template>

<script>
export default {
  name: "SuccessResponse"
}
</script>

<style scoped>
.success {
  color: grey;
  font-size: 10rem;
}
</style>
