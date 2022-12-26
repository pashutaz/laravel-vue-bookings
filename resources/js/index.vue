<template>
  <div>
    <nav class="navbar bg-dark navbar-dark sticky-top">
      <router-link :to="{ name: 'home' }" class="navbar-brand mr-auto text-white">Bookings</router-link>

      <div class="nav-item dropdown">
        <button aria-expanded="false" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" type="button">
          <i class="fas fa-bars"/>
          <i class="fas fa-user-circle"/>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <router-link :to="{ name: 'shopping-cart' }" class="dropdown-item">
            Shopping Cart
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-white">
              {{ countCartItems }}
            </span>
          </router-link>
          <div class="dropdown-divider"></div>
          <div v-if="!this.isUserLoggedIn">
            <router-link :to="{ name: 'login' }" class="dropdown-item">Log in</router-link>
            <router-link :to="{ name: 'register' }" class="dropdown-item">Sign up</router-link>
          </div>
          <a v-else class="dropdown-item" @click="logout">Logout</a>
        </div>
      </div>
    </nav>

    <div class="container mt-4 mb-4 pr-4 pl-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
  computed: {
    ...mapGetters(['isUserLoggedIn']),

    countCartItems: function () {
      return this.$store.getters.cartCount;
    }
  },

  methods: {
    async logout() {
      if (confirm('Want to logout?')) {
        await axios.post('/logout');
        await this.$store.dispatch('logOut');
        await this.$router.push({name: 'home'});
      }
    }
  }
}
</script>
