<template>
  <div class="row">
    <fatal-error v-if="error"></fatal-error>
    <success-response v-if="200 === status">Thank you for your review!</success-response>
    <template v-if="loading">Loading...</template>
    <template v-else-if="!error && 200 !== status">
      <div :class="[{'col-md-4': twoRowsOption}, {'d-none': oneRowOption}]">
        <div v-if="hasBooking" class="card">
          <div class="card-body">
            <p>
              Stayed at
              <router-link :to="{name: 'bookable.show', params: {id: booking.bookable.id}}">
                {{ booking.bookable.title }}
              </router-link>
            </p>
            <p>From {{ booking.from }} to {{ booking.to }}</p>
          </div>
        </div>
      </div>
      <div :class="[{'col-md-8': twoRowsOption}, {'col-md-12': oneRowOption}]">
        <template v-if="alreadyReviewed">
          <success-response><h3>You have already reviewed this booking, nice work!</h3></success-response>
        </template>
        <template v-else>
          Review page
          <div class="form-group">
            <label class="text-muted">Select the star rating</label>
            <star-rating v-model="review.rating" class="fa-3x" />
          </div>
          <div class="form-group">
            <label class="text-muted" for="content">
              Describe your experience
            </label>
            <textarea
              id="content"
              v-model="review.content"
              class="form-control"
              cols="30"
              name="content"
              rows="10"
              :class="{'is-invalid': getErrorsFor('content')}"
            ></textarea>
            <invalid-feedback :errors="getErrorsFor('content')" />
          </div>

          <button :disabled="sending" class="btn btn-lg btn-primary btn-block" @click.prevent="submit">
            Submit
          </button>
        </template>
      </div>
    </template>
  </div>
</template>


<script>
import InvalidFeedback from "../shared/components/InvalidFeedback";
import validationErrors from "../shared/mixins/validationErrors";

export default {
  components: {
    InvalidFeedback
  },
  mixins: [validationErrors],

  data() {
    return {
      loading: false,
      sending: false,
      error: false,
      review: {
        id: null,
        rating: 5,
        content: null,
      },
      existingReview: null,
      booking: null
    };
  },

  created() {
    this.loading = true;

    this.review.id = this.$route.params.id;

    axios.get(`/api/reviews/${this.review.id}`)
      .then((response) => (this.existingReview = response.data))
      .catch((error) => {
        console.log(error);

        if (error.response && error.response.status && 404 === error.response.status) {
          return axios.get(`/api/booking-by-review/${this.review.id}`)
            .then((response) => (this.booking = response.data))
            .catch(err => this.error = true);
        }

        this.error = true;
      })
      .finally(() => (this.loading = false));
  },

  computed: {
    alreadyReviewed() {
      return this.existingReview !== null && this.existingReview !== undefined;
    },

    hasBooking() {
      return this.booking !== null && this.booking !== undefined;
    },

    oneRowOption() {
      return !this.loading && this.alreadyReviewed;
    },

    twoRowsOption() {
      return this.loading || !this.alreadyReviewed;
    }
  },

  methods: {
    // onRatingsChanged(rating) {
    //   console.log(rating);
    //   this.review.rating = rating;
    // },

    submit() {
      this.sending = true;
      return axios.post(`/api/reviews`, this.review)
        .then(res => this.status = res.status)
        .catch(err => {
          this.status = err.response.status;
          this.errors = err.response.data.errors;

          if (!this.hasValidationErrors) {
            this.error = true;
          }
        })
        .finally(() => this.sending = false)
    }
  },
};
</script>
