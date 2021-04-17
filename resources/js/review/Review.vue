<template>
  <div>
    Review page
    <div class="form-group">
        <label for="" class="text-muted">Select the star rating</label>
        <star-rating :rating="review.rating" class="fa-3x" @rating:changed="onRatingsChanged"></star-rating>
    </div>
    <div class="form-group">
        <label for="content" class="text-muted">Describe your experience</label>
        <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
    </div>

    <button class="btn btn-lg btn-primary btn-block">Submit</button>
  </div>
</template>


<script>
export default {
  data() {
    return {
      review: {
        rating: 5,
        content: null
      }
    };
  },

  methods: {
    onRatingsChanged(rating) {
      console.log(rating);
      this.review.rating = rating;
    }
  }
};
</script>
