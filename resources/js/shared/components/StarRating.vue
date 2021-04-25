<template>
    <div class="d-flex align-items-center">
        <span class="pr-1 text-muted">{{ this.value }}</span>
        <i
            class="fas fa-star"
            v-for="star in fullStars"
            :key="'full' + star"
            @click="$emit('input', star)"
        ></i>
        <i class="fas fa-star-half-alt" v-if="halfStar"></i>
        <i
            class="far fa-star"
            v-for="star in emptyStars"
            :key="'empty' + star"
            @click="$emit('input', star + fullStars)"
        ></i>
    </div>
</template>

<script>
export default {
    props: {
        value: Number,
    },

    computed: {
        halfStar() {
            /* if we have decimal part then display half star */
            return Boolean(this.value % 1);
        },
        fullStars() {
            /* display full stars only for natural numbers*/
            return Math.floor(this.value);
        },
        emptyStars() {
            /* 5 - ceil(3.5) = 1 empty star */
            return 5 - Math.ceil(this.value);
        },
    },
};
</script>

<style scoped>
i {
    color: gold;
}
</style>
