<template>
  <div class="row">
    <div class="col-12 mb-4">
      <h4>
        <button class="btn btn-outline-secondary rounded-pill" @click="$router.go(-1)">&lt;</button>
        <span class="ml-2 text-uppercase"> Confirm and pay </span>
      </h4>
    </div>

    <div class="col-md-8">
      <form>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="user-email">Email</label>
            <input id="user-email" class="form-control" name="email" placeholder="johndoe90@gmail.com" type="email">
          </div>
          <div class="form-group col-md-6">
            <label for="user-name">Name</label>
            <input id="user-name" class="form-control" name="name" placeholder="John Doe" type="text">
          </div>
        </div>
        <div class="form-group">
          <label for="user-address">Address</label>
          <input id="user-address" class="form-control" name="main-address" placeholder="1234 Main St" type="text">
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="user-city">City</label>
            <input id="user-city" class="form-control" name="city" type="text">
          </div>
          <div class="form-group col-md-4">
            <label for="user-country">Country</label>
            <input id="user-country" class="form-control" name="country" type="text">
          </div>
          <div class="form-group col-md-2">
            <label for="user-zip">Zip</label>
            <input id="user-zip" class="form-control" name="zip" type="text">
          </div>
        </div>
        <div class="form-group">
          <div class="form-check">
            <input id="gridCheck" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="gridCheck">
              Check me out
            </label>
          </div>
        </div>
        <hr />
        <button class="btn btn-outline-success btn-lg btn-block" type="submit">Reserve</button>
      </form>
    </div>

    <div class="col-md-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Your cart</span>
        <span class="badge badge-secondary badge-pill">{{ cartCount }}</span>
      </h4>
      <div class="card">
        <div class="card-body">
          <transition-group name="fade">
            <div v-for="{ bookable, price, dates } in cartItems" :key="bookable.id" class="pb-2">
              <div class="d-flex justify-content-between">
                <router-link :to="{ name: 'bookable.show', params: { id: bookable.id } }">
                  {{ bookable.title }}
                </router-link>
                <span class="font-weight-bold">${{ price.total }}</span>
              </div>
              <div class="text-muted d-flex justify-content-between">
                <span>From {{ dates.from }}</span>
                <span>To {{ dates.to }}</span>
              </div>

              <div class="text-right">
                <button class="btn btn-sm btn-outline-danger" @click="removeItemFromCart(bookable.id)">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </div>
            </div>
          </transition-group>
        </div>
        <div class="card-footer">
          <h4>Total: <span class="badge badge-success float-right">${{ cartTotal }}</span></h4>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  name: "ShoppingCart",

  computed: {
    ...mapGetters(['cartItems', 'cartTotal', 'cartCount'])
  },

  methods: {
    ...mapActions({
      removeItemFromCart: 'removeItemFromCart'
    })
  }
}
</script>
