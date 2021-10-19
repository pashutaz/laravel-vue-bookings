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

      <review-list :bookable-id="String(this.$route.params.id)"></review-list>
    </div>
    <div class="col-md-4 pt-4">
      <availability
        :bookable-id="String(this.$route.params.id)"
        @available="checkPrice($event)"
        class="mb-4"
      ></availability>

      <transition name="slide-fade">
        <div v-if="price">
          <price-breakdown :full-price="price"></price-breakdown>

          <button class="btn btn-outline-secondary btn-block"> Book now </button>
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
      console.log(event);

      if (! event) {
        this.price = null;
        return;
      }

      const from = this.$store.state.lastDateCheck.from,
        to = this.$store.state.lastDateCheck.to;

      try {
        this.price = (
          await axios.get(`/api/bookables/price?price=${this.bookable.price}&from=${from}&to=${to}`)
        ).data.data;
      } catch (e) {
        this.price = null;
      }
    }
  }
};
</script>
