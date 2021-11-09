<template>
  <div>
    <nav class="navbar bg-white border-bottom navbar-light">
      <router-link class="navbar-brand mr-auto" :to="{ name: 'home' }">
        LaravelBnb
      </router-link>
      <button type="button" class="btn btn-secondary position-relative">
        Shopping Cart
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          {{ countCartItems }}
        </span>
      </button>
      <!-- <router-link class="btn nav-button" :to="{ name: 'second' }">Second</router-link>-->
    </nav>

    <div class="container mt-4 mb-4 pr-4 pl-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    countCartItems: function () {
      return this.$store.getters.cartCount;
    }
  }
}
</script>
