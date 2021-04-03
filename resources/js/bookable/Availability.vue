<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bolder">
      Check Availability
      <div v-if="available" class="text-success">(available)</div>
      <div v-if="notAvailable" class="text-danger">(not available)</div>
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
          :class="[{ 'is-invalid': this.errorFor('from') }]"
        />
        <div
          class="invalid-feedback"
          v-for="(error, index) in this.errorFor('from')"
          :key="'from' + index"
        >
          {{ error }}
        </div>
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
          :class="[{ 'is-invalid': this.errorFor('to') }]"
        />
        <div
          class="invalid-feedback"
          v-for="(error, index) in this.errorFor('to')"
          :key="'from' + index"
        >
          {{ error }}
        </div>
      </div>

      <button
        class="btn btn-secondary btn-block"
        @click="check"
        :disabled="loading"
      >
        Check!
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      from: new Date().toLocaleDateString("en-CA"),
      to: new Date().toLocaleDateString("en-CA"),
      loading: false,
      status: null,
      errors: null,
    };
  },

  methods: {
    check() {
      this.loading = true;
      this.errors = null;

      axios
        .get(
          `/api/bookables/${this.$route.params.id}/availability?from=${this.from}&to=${this.to}`
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

    errorFor(field) {
      return this.hasErrors && this.errors[field] ? this.errors[field] : null;
    },
  },

  computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
    available() {
      return 200 === this.status;
    },
    notAvailable() {
        return 404 === this.status;
    }
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
