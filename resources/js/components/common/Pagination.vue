<template>
       <v-pagination
        :length="totalPages"
        @click="update"
        color="primary"
        rounded="circle"
        :disabled="totalPages < 2"
        prev-icon="fa-solid fa-chevron-left"
        next-icon="fa-solid fa-chevron-right"
      >
      </v-pagination>
</template>

<script>
    export default {
        props: {
            totalPages: Number,
        },
        methods: {
            update() {
                this.$emit("loadPage");
            },
        }
    }
</script>

<style lang="scss">
.v-btn:hover > .v-btn__overlay {
    opacity: 20% !important;
}
</style>