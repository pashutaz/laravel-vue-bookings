<template>
    <div class="d-flex align-items-center">
        <span class="pr-1 text-muted">{{ this.rating }}</span>
        <i class="fas fa-star" v-for="star in fullStars" :key="'full' + star"></i>
        <i class="fas fa-star-half-alt" v-if="halfStar"></i>
        <i class="far fa-star" v-for="star in emptyStars" :key="'empty' + star"></i>
    </div>
</template>

<script>
export default {
    props: {
        rating: Number
    },

    computed: {
        halfStar() {
            /* if we have decimal part then display half star */
            return Boolean(this.rating % 1);
        },
        fullStars() {
            /* display full stars only for natural numbers*/
            return Math.floor(this.rating);
        },
        emptyStars() {
            /* 5 - ceil(3.5) = 1 empty star */
            return 5 - Math.ceil(this.rating);
        }
    },
}
</script>

<style scoped>
    i {
        color: gold;
    }
</style>
