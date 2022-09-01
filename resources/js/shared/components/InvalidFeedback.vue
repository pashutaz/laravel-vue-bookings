<template>
  <div class="invalid-feedback">
    <p v-for="error in errors" :key="error">
      {{ error }}
    </p>
  </div>
</template>

<script>
export default {
  name: "InvalidFeedback",

  props: {
    errors: Array,
  },
};
</script>
