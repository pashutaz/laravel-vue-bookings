<template>
  <div>
    <div v-if="loading">Data is loading...</div>
    <div v-else>
      <div class="row mb-4" v-for="row in rows" :key="row">
        <div
          class="col"
          v-for="(bookable, column) in bookablesInRow(row)"
          :key="'row' + row + column"
        >
          <BookableListItem
            :title="bookable.title"
            :content="bookable.content"
            :price="bookable.price"
          ></BookableListItem>
        </div>

        <div
          class="col"
          v-for="p in placeholdersInRow(row)"
          :key="'placeholder' + row + p"
        ></div>
      </div>
    </div>
  </div>
</template>

<script>
import BookableListItem from "./bookableListItem";

export default {
  components: {
    BookableListItem,
  },
  data() {
    return {
      bookables: null,
      loading: true,
      columns: 3,
    };
  },
  computed: {
    rows() {
      return this.bookables ? Math.ceil(this.bookables.length / this.columns) : 0;
    },
  },
  methods: {
    bookablesInRow(row) {
      return this.bookables.slice((row - 1) * this.columns, row * this.columns);
    },
    placeholdersInRow(row) {
      return this.columns - this.bookablesInRow(row).length;
    },
  },

  // beforeCreate() {

  // },
  created() {
    setTimeout(() => {
      this.bookables = [
        {
          title: "Cheap villa1",
          content: "Very cheap villa",
          price: 1000.0,
        },
        {
          title: "Cheap villa2",
          content: "Very cheap villa2",
          price: 777.0,
        },
        {
          title: "Cheap villa1",
          content: "Very cheap villa",
          price: 1000.0,
        },
        {
          title: "Cheap villa2",
          content: "Very cheap villa2",
          price: 777.0,
        },
        {
          title: "Cheap villa1",
          content: "Very cheap villa",
          price: 1000.0,
        },
        {
          title: "Cheap villa2",
          content: "Very cheap villa2",
          price: 777.0,
        },
        {
          title: "Cheap villa2",
          content: "Very cheap villa2",
          price: 777.0,
        },
      ];
      this.loading = false;
    }, 2000);
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

<style scope></style>
