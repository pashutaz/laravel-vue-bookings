<template>
    <div>
        <template v-if="loading">Loading...</template>
        <template v-else>
            <template v-if="alreadyReviewed">
                <h3>You've already reviewed this booking, nice work!</h3>
            </template>
            <template v-else>
                Review page
                <div class="form-group">
                    <label for="" class="text-muted">
                        Select the star rating
                    </label>
                    <star-rating
                        class="fa-3x"
                        v-model="review.rating"
                    ></star-rating>
                </div>
                <div class="form-group">
                    <label for="content" class="text-muted">
                        Describe your experience
                    </label>
                    <textarea
                        name="content"
                        id="content"
                        cols="30"
                        rows="10"
                        class="form-control"
                        v-model="review.content"
                    ></textarea>
                </div>

                <button class="btn btn-lg btn-primary btn-block">Submit</button>
            </template>
        </template>
    </div>
</template>


<script>
export default {
    data() {
        return {
            review: {
                rating: 5,
                content: null,
            },
            existingReview: null,
            loading: false,
        };
    },

    created() {
        this.loading = true;

        axios
            .get(`/api/reviews/${this.$route.params.id}`)
            .then((response) => (this.existingReview = response.data.data))
            .catch((error) => console.log(error))
            .finally(() => (this.loading = false));
    },

    computed: {
        alreadyReviewed() {
            return this.existingReview !== null;
        },
    },

    // methods: {
    //   onRatingsChanged(rating) {
    //     console.log(rating);
    //     this.review.rating = rating;
    //   },
    // },
};
</script>
