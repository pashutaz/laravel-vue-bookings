<template>
  <div class="row">
    <div class="col-md-8">
      <button class="btn btn-secondary rounded-pill" @click="$router.go(-1)"><</button>
      <span class="text-uppercase"> Confirm and pay </span>

    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          Total: <span class="badge badge-primary float-right">{{ this.cartCount }}</span>
        </div>
        <div class="card-body">
          <div v-for="{bookable, price, dates} in cartItems" class="pb-2">
            <div class="d-flex justify-content-between">
              <router-link :to="{ name: 'bookable.show', params: {id: bookable.id} }">
                {{ bookable.title }}
              </router-link>
              <span class="font-weight-bold">${{ price.total }}</span>
            </div>
            <div class="text-muted d-flex justify-content-between">
              <span>From {{ dates.from }}</span>
              <span>To {{ dates.to }}</span>
            </div>

            <div class="text-right">
              <button class="btn btn-sm btn-danger" @click="removeItemFromCart(bookable.id)">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";

export default {
  name: "ShoppingCart",

  computed: {
    ...mapGetters({
      cartCount: "cartCount",
      cartItems: "cartItems"
    })
  },

  methods: {
    ...mapActions({
      removeItemFromCart: 'removeItemFromCart'
    })
  }
}
</script>
