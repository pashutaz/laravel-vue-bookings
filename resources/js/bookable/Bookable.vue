<template>
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div v-if="!loading">
          <div class="card-header">
            {{ bookable.title }}
          </div>
          <div class="card-body">
            <p class="card-text">{{ bookable.description }}</p>
          </div>
        </div>
        <div v-else>Loading...</div>
      </div>
      <hr>
      <img :src="`https://picsum.photos/700/300?random=${ Math.floor(Math.random()*100) }`" alt="image" class="w-100">
      <hr>
      <review-list :bookable-id="String(this.$route.params.id)"></review-list>
    </div>
    <div class="col-md-4 pt-4">
      <availability
        :bookable-id="String(this.$route.params.id)"
        class="mb-4"
        @available="checkPrice($event)"
      ></availability>

      <transition name="slide-fade">
        <div v-if="price">
          <price-breakdown :full-price="price"></price-breakdown>

          <button v-if="!this.cartHasThisBooking" class="btn btn-success btn-block" @click="addItemToCart()">
            Book now
          </button>
          <button v-else class="btn btn-secondary btn-block" @click="removeItemFromCart()">
            Remove from the cart
          </button>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";
import PriceBreakdown from "./PriceBreakdown";

export default {
  components: {
    Availability,
    ReviewList,
    PriceBreakdown
  },

  data() {
    return {
      bookable: null,
      loading: false,
      /**
       * Bookable price data object
       * @property {number} total
       * @property {Object} breakdown
       */
      price: null
    };
  },

  created() {
    this.loading = true;

    axios.get(`/api/bookables/${this.$route.params.id}`).then((response) => {
      this.bookable = response.data.data;
      this.loading = false;
    });
  },

  methods: {
    async checkPrice(event) {
      if (! event) {
        this.price = null;
        return;
      }

      const dates = this.$store.state.lastDateCheck;

      try {
        this.price = (
          await axios.get(`/api/bookables/price?price=${this.bookable.price}&from=${dates.from}&to=${dates.to}`)
        ).data.data;
      } catch (e) {
        this.price = null;
      }
    },

    addItemToCart() {
      this.$store.commit('addItemToCart', {
        bookable: this.bookable,
        price: this.price,
        dates: this.$store.state.lastDateCheck
      })
    },

    removeItemFromCart() {
      this.$store.commit('removeItemFromCart', this.bookable.id)
    }
  },

  computed: {
    cartHasThisBooking() {
      return (this.bookable !== null)
        ? !!this.$store.getters.getCartItemById(this.bookable.id)
        : false;
    }
  }
};
</script>
