<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bolder">
      Check Availability
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
        />
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
        />
      </div>

      <button class="btn btn-secondary btn-block" @click="check">Check!</button>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            from: new Date().toLocaleDateString('en-CA'),
            to: new Date().toLocaleDateString('en-CA')
        };
    },

    methods: {
        check() {
            alert('feck');
        }
    }
}
</script>

<style scoped>
label {
  font-size: 0.7rem;
  text-transform: uppercase;
  color: gray;
  font-weight: bolder;
}
</style>
