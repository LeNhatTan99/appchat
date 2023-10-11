<template>
  <!-- Form login -->
  <div class="main">
    <div class="form ">
      <div class="tab-btn">
        <router-link class="btn-login active" :to="{ name: 'userLogin' }">Đăng nhập</router-link>
        <router-link class="btn-register" :to="{ name: 'userRegister' }">Đăng ký</router-link>
      </div>

      <!-- Form login -->
      <div class="form-login form-item">
        <form id="form-login" @submit.prevent="login">
          <div class="border-form">
            <div class="form-group">
              <label for="" class="form-label">Email</label>
              <input type="email" id="email" class="form-control" v-model="email">
              <span class="form-message"></span>
            </div>

            <div class="form-group">
              <label for="" class="form-label">Mật khẩu</label>
              <input type="password" id="password" class="form-control" v-model="password">
              <span class="form-message"></span>
            </div>

            <button id="formSubmit" class="form-submit">Đăng nhập</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
  
<script>

export default {
  data() {
    return {
      email: null,
      password: null,
      error: false,
      remember: false
    };
  },
  methods: {

    async login() {
      this.loading = true;
      this.errors = null;
      try {
        this.$store.dispatch('login', {
          email: this.email,
          password: this.password,
          remember: this.remember,
        });

      } catch (error) {
        if (e.status === 422) {
          alert(422);
        }
        if (e.status === 401) {
          alert(401);
        }
      }
    }
  }
};
</script>
<style lang="scss">
    @import "../../../sass/auth/index.scss";
</style>
 