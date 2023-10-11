<template>

<div class="main">
    <div class="form " >
      <div class="tab-btn">
        <router-link class="btn-login" :to="{ name: 'userLogin' }">Đăng nhập</router-link>
        <router-link class="btn-register active" :to="{ name: 'userRegister' }">Đăng ký</router-link>
      </div>     
     <div class="form-register form-item">
         <form id="form-register" @submit.prevent="register">
            <div class="border-form">
              <div class="form-group">
                  <label for="" class="form-label">Họ và tên</label>
                  <input type="text" id="fullname"  class="form-control" v-model="full_name">
                  <span class="error-message">{{ errors.full_name }}</span>
              </div>
              <div class="form-group">
                  <label for="" class="form-label">Email</label>
                  <input type="email" id="email" class="form-control" v-model="email">
                  <span class="error-message">{{ errors.email }}</span>
              </div>
      
              <div class="form-group">
                  <label for="" class="form-label">Mật khẩu</label>
                  <input type="password" id="password" class="form-control" v-model="password">
                  <span class="error-message">{{ errors.password }}</span>
              </div>
                   
              <div class="form-group">
                 <label for="" class="form-label">Nhập lại mật khẩu</label>
                 <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation">
                 <span class="error-message">{{ errors.password_confirmation }}</span> 
             </div>
        
              <button type="submit"  class="form-submit">Đăng ký</button>
            </div>
             </form>
     </div>

</div>
</div>
  </template>
  
  <script>
  import axios from 'axios';
  import Toast from '../../nofitication/toast';
  export default {
    data() {
      return {
        full_name : null,
        email: null,
        password: null,
        password_confirmation: null,
        errors: {
          full_name: null,
          email: null,
          password: null,
          password_confirmation: null,
        }
      };
    },
    methods: {
    async register() {
      try {
        const response = await axios.post('/api/user/register', {
          full_name: this.full_name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        });
        if (response.data.message) {
          Toast.showToast('success', response.data.message)
          this.$router.push({ name: 'userLogin' });
        } 
      } catch (error) {
        if (error.response && error.response.data && error.response.data.error) {
          const errorMessages = error.response.data.error;
          for (const field in this.errors) {
            this.errors[field] = null;
            if (errorMessages.hasOwnProperty(field)) {
              this.errors[field] = errorMessages[field].join('\n');
            }
        }
        }
      }
    }
  }
  };
  </script>
<style lang="scss">
  @import "../../../sass/auth/index.scss";
</style>