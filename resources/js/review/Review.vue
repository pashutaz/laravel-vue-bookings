<template>
    <div class="row">
        <fatal-error v-if="error"></fatal-error>
        <template v-if="loading">Loading...</template>
        <template v-else-if="!error">
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
                    <h3>You have already reviewed this booking, nice work!</h3>
                </template>
                <template v-else>
                    Review page
                    <div class="form-group">
                        <label class="text-muted">
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

                    <button class="btn btn-lg btn-primary btn-block" :disabled="loading" @click.prevent="submit">
                        Submit
                    </button>
                </template>
            </div>
        </template>
    </div>
</template>


<script>
export default {
    data() {
        return {
            loading: false,
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
            this.loading = true;
            return axios.post(`/api/reviews`, this.review)
                .catch(err => this.error = true)
                .finally(() => this.loading = false)
        }
    },
};
</script>
