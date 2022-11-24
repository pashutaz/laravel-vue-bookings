<template>
  <div>
    <div v-if="loading">Data is loading...</div>
    <div v-else class="row">
      <bookable-list-item
        v-for="bookable in bookables"
        :key="bookable.id"
        v-bind="bookable"
        class="col-md-4 mb-3 p-0"
      />
    </div>
  </div>
</template>

<script>
import BookableListItem from "./BookableListItem";

export default {
  components: {
    BookableListItem,
  },

  data() {
    return {
      bookables: null,
      loading: false,
    };
  },

  // beforeCreate() {

  // },
  created() {
    this.loading = true;

    const request = axios.get("/api/bookables").then((response) => {
      this.bookables = _.sortBy(response.data.data, 'price');
      this.loading = false;
    });
  },
  // beforeMount() {

  // },
  // mounted() {

  // },
  // beforeDestroy() {

  // },
  // destroyed() {

  // },
};
</script>

<style scoped>
.row {
  /*gap: 5px;*/
}
</style>
