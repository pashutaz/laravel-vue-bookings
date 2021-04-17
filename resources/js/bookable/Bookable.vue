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
      <availability :bookable-id="String(this.$route.params.id)"></availability>
    </div>
  </div>
</template>

<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";

export default {
  components: {
    Availability,
    ReviewList,
  },

  data() {
    return {
      bookable: null,
      loading: false,
    };
  },

  created() {
    this.loading = true;
    // console.log(this.$route.params.id);
    axios.get(`/api/bookables/${this.$route.params.id}`).then((response) => {
      this.bookable = response.data.data;
      this.loading = false;
    });
  },
};
</script>
