<template>
  <div class="row">
    <div class="col-12 mb-4">
      <h4>
        <button class="btn btn-outline-secondary rounded-pill" @click="$router.go(-1)">&lt;</button>
        <span class="ml-2 text-uppercase"> Confirm and pay </span>
      </h4>
    </div>

    <div class="col-md-8">
      <form v-if="cartCount" @submit.prevent="submit">
        <div class="form-group">
          <label for="user-email">Email</label>
          <input
            id="user-email"
            v-model="user.email"
            :class="[{ 'is-invalid': getErrorsFor('email') }]"
            class="form-control"
            name="email"
            placeholder="johndoe90@gmail.com"
            required
            type="email"
          />
          <invalid-feedback :errors="getErrorsFor('email')"/>
        </div>

        <div class="form-group">
          <label for="user-name">Name</label>
          <input
            id="user-name"
            v-model="user.name"
            :class="[{ 'is-invalid': getErrorsFor('name') }]"
            class="form-control"
            name="name"
            placeholder="John Doe"
            required
            type="text"
          />
          <invalid-feedback :errors="getErrorsFor('name')"/>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="user-country">Country/Region</label>
            <input
              id="user-country"
              v-model="user.country"
              :class="[{ 'is-invalid': getErrorsFor('country') }]"
              class="form-control"
              name="country"
              type="text"
            />
            <invalid-feedback :errors="getErrorsFor('country')"/>
          </div>

          <div class="form-group col-md-6">
            <label for="user-phone">Phone</label>
            <input
              id="user-phone"
              v-model="user.phone"
              :class="[{ 'is-invalid': getErrorsFor('phone') }]"
              class="form-control"
              name="main-phone"
              type="text"
            />
            <invalid-feedback :errors="getErrorsFor('phone')"/>
          </div>
        </div>

        <div class="form-group">
          <div class="form-check">
            <input id="remember" :checked="isRemember" class="form-check-input" type="checkbox"/>
            <label class="form-check-label" for="remember">Remember me</label>
          </div>
        </div>

        <hr/>

        <button :disabled="loading" class="btn btn-outline-success btn-lg btn-block" type="submit">
          Reserve
        </button>
      </form>

      <div v-else class="jumbotron text-center">
        <h1>Try adding something to your cart</h1>
      </div>
    </div>

    <div class="col-md-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Your cart</span>
        <span class="badge badge-secondary badge-pill">{{ cartCount || "empty" }}</span>
      </h4>

      <div class="card">
        <div v-if="cartCount" class="card-body">
          <transition-group name="fade">
            <div
              v-for="{ bookable, price, dates } in cartItems"
              :key="bookable.id"
              class="pb-2"
            >
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
                <button
                  class="btn btn-sm btn-outline-danger"
                  @click="removeItemFromCart(bookable.id)"
                >
                  <i class="fas fa-trash-alt"/>
                </button>
              </div>
            </div>
          </transition-group>
        </div>

        <div class="card-footer">
          <h4>
            Total:
            <span class="badge badge-success float-right">${{ cartTotal }}</span>
          </h4>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import validationErrors from "../shared/mixins/validationErrors";
import InvalidFeedback from "../shared/components/InvalidFeedback";

export default {
  name: "ShoppingCart",

  mixins: [validationErrors],

  components: {InvalidFeedback},

  data() {
    return {
      loading: false,

      isRemember: false,
      user: {
        phone: null,
        name: null,
        email: null,
        country: null,
      },
    };
  },

  computed: {
    ...mapGetters(["cartItems", "cartTotal", "cartCount"]),
  },

  methods: {
    ...mapActions(["removeItemFromCart"]),

    async submit() {
      this.loading = true;
      this.errors = null;

      try {
        await axios.post("/api/checkout", {
          ...this.user,
          bookings: this.cartItems.map(item => ({
            bookable_id: item.bookable.id,
            from: item.dates.from,
            to: item.dates.to
          }))
        });
      } catch (e) {
        this.errors = e.response && e.response.data.errors;
        this.status = e.response.status;

        this.$toast(e.response.data.message);
      } finally {
        this.loading = false;
      }
    },

  },
};
</script>
