<template>
    <div class="d-none d-md-block">
        <h6 class="text-uppercase text-secondary font-weight-bolder pt-4">
            review list
        </h6>

        <div v-if="loading">
            <h3>Loading...</h3>
        </div>
        <div v-else>
            <div
                class="border-bottom"
                v-for="(review, index) in reviews"
                :key="index"
            >
                <div class="row pt-3">
                    <div class="col-md-6 font-italic">Pashutaz</div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <star-rating class="fa-lg" :value="parseFloat(review.rating)" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        {{ review.created_at | fromNow }}
                    </div>
                </div>

                <div class="row pt-3 pb-3">
                    <div class="col-md-12">{{ review.content }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        bookableId: String,
    },

    data() {
        return {
            loading: false,
            reviews: null,
        };
    },

    created() {
        this.loading = true;
        axios
            .get(`/api/bookables/${this.bookableId}/reviews`)
            .then((response) => {
                this.reviews = response.data.data;
            })
            .then(() => (this.loading = false));
    },

    //   filters: {
    //       fromNow(value) {
    //           return moment(value).fromNow();
    //       }
    //   }
};
</script>
