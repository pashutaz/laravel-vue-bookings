<template>
  <div>
    <nav class="navbar bg-dark border-bottom navbar-light">
      <router-link :to="{ name: 'home' }" class="navbar-brand mr-auto text-white">Bookings</router-link>
      <router-link :to="{ name: 'shopping-cart' }" class="mr-2">
        <button class="btn btn-secondary position-relative" type="button">
          Shopping Cart
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ countCartItems }}
          </span>
        </button>
      </router-link>

      <div v-if="!isLoggedIn">
        <router-link :to="{ name: 'login' }">
          <button class="btn btn-sm btn-outline-info" type="button">Log in</button>
        </router-link>
        <router-link :to="{ name: 'register' }">
          <button class="btn btn-sm btn-outline-info" type="button">Sign up</button>
        </router-link>
      </div>

      <button v-else class="btn btn-sm btn-outline-info" type="button" @click="logout">Logout</button>
    </nav>

    <div class="container mt-4 mb-4 pr-4 pl-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import {mapState} from "vuex";

export default {
  computed: {
    ...mapState(['isLoggedIn']),

    countCartItems: function () {
      return this.$store.getters.cartCount;
    }
  },

  methods: {
    async logout() {
      await axios.post('/logout');
      this.$store.dispatch('logOut');
    }
  }
}
</script>
