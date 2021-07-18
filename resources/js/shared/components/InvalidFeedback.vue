<template>
  <div class="invalid-feedback">
    <p v-for="error in errors">
      {{ error }}
    </p>
  </div>
</template>

<script>
export default {
  name: "InvalidFeedback",

  props: {
    errors: Array
  },
}
</script>
