<template>
    <div class="container text-center error">
        <i class="fas fa-bomb"></i>
        <h1 class="mt-4">Something went wrong</h1>
        <h2>We are sorry, try again later</h2>
    </div>
</template>

<script>
export default {
    name: "FatalError"
}
</script>

<style scoped>
.error {
    color: grey;
    font-size: 10rem;
}
</style>
