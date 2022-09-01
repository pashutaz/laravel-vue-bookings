<template>
  <div>
    <nav class="navbar bg-dark border-bottom navbar-light">
      <router-link :to="{ name: 'home' }" class="navbar-brand mr-auto text-white"> Bookings</router-link>
      <router-link :to="{ name: 'shopping-cart' }">
        <button class="btn btn-secondary position-relative" type="button">
          Shopping Cart
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ countCartItems }}
          </span>
        </button>
      </router-link>
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
