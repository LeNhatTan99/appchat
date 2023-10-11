<template>
    <div id="layout-wrapper">
            <router-view />
    </div>
    <!-- END layout-wrapper -->
</template>
<script>
export default {
    data: () => {
      return {
          currentUserLogin: {},
      };
  },
  mounted() {
      this.getCurrentUserLogin();
  },
  methods: {
      async getCurrentUserLogin() {
          try {
              const response = await axios.get("/getUserLogin");
              this.currentUserLogin = response.data;
          } catch (error) {
              console.log(error);
          }
      },
  },
}
</script>
<style lang="scss">
  @import "../sass/app.scss";
</style>