<template>
<div>
  <h6 class="text-uppercase text-secondary font-weight-bolder">
    Price Breakdown
  </h6>

  <div v-for="(days, price) in fullPrice.breakdown" class="d-flex justify-content-between">
    <span>{{ price }}$ X {{ days }} days</span>
    <span>{{ (price*days).toFixed(2) }}$</span>
  </div>
  <hr>
  <div class="pb-3 d-flex justify-content-between">
    <span>Total</span>
    <span>{{ fullPrice.total }}$</span>
  </div>
</div>
</template>

<script>
export default {
  name: "PriceBreakdown",

  props: {
    fullPrice: Object
  }
}
</script>

<style scoped>

</style>
