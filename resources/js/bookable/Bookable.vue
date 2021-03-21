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
    </div>
    <div class="col-md-4">
      TO-DO
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      bookable: null,
      loading: false
    };
  },
  created() {
    this.loading = true;
    // console.log(this.$route.params.id);
    axios.get(`/api/bookables/${this.$route.params.id}`).then((response) => {
      this.bookable = response.data;
      this.loading = false;
    });
  },
};
</script>