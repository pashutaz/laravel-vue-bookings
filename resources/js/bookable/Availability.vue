<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bolder">
      Check Availability
      <transition name="slide-fade">
        <div v-if="available" class="text-success">(available)</div>
        <div v-if="notAvailable" class="text-danger">(not available)</div>
      </transition>
    </h6>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="from">From</label>
        <input
          id="from"
          type="date"
          name="from"
          class="form-control form-control-sm"
          v-model="from"
          @keyup.enter="check"
          :class="[{ 'is-invalid': getErrorsFor('from') }]"
        />
        <invalid-feedback :errors="getErrorsFor('from')"></invalid-feedback>
      </div>

      <div class="form-group col-md-6">
        <label for="to">To</label>
        <input
          id="to"
          type="date"
          name="to"
          class="form-control form-control-sm"
          v-model="to"
          @keyup.enter="check"
          :class="[{ 'is-invalid': getErrorsFor('to') }]"
        />
        <invalid-feedback :errors="getErrorsFor('to')"></invalid-feedback>
      </div>

      <button
        class="btn btn-secondary btn-block"
        @click="check"
        :disabled="loading"
      >
        <template v-if="loading"><i class="fas fa-spinner fa-pulse"></i>Checking...</template>
        <template v-else>Check!</template>
      </button>
    </div>
  </div>
</template>

<script>
import InvalidFeedback from "../shared/components/InvalidFeedback";
import validationErrors from "../shared/mixins/validationErrors";

export default {
  name: 'Availability',

  mixins: [validationErrors],

  props: {
    bookableId: String,
  },

  components: {
    InvalidFeedback
  },

  data() {
    return {
      from: this.$store.state.lastDateCheck.from,
      to: this.$store.state.lastDateCheck.to,
      loading: false,
      status: null,
    };
  },

  methods: {
    check() {
      this.loading = true;
      this.errors = null;

      this.$store.dispatch('setLastDateCheck', {
        from: this.from,
        to: this.to
      });

      axios
        .get(
          `/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`
        )
        .then((response) => {
          console.log(response);
          this.status = response.status;
        })
        .catch((error) => {
          if (422 === error.response.status) {
            this.errors = error.response.data.errors;
          }
          this.status = error.response.status;
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },

  computed: {
    available() {
      return 200 === this.status;
    },
    notAvailable() {
      return 404 === this.status;
    },
  },
};
</script>

<style scoped>
label {
  font-size: 0.7rem;
  text-transform: uppercase;
  color: gray;
  font-weight: bolder;
}
</style>
