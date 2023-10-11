import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import axios from 'axios';
import router from './route';
import store from "./store";
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import ChatLayout from './components/chat/ChatLayout.vue'

const app = createApp(App);
// const app = createApp({    
//   data: () => {
//   return {
//       currentUserLogin: {},
//   };
// },
// created() {
//   this.getCurrentUserLogin();
// },
// methods: {
//   async getCurrentUserLogin() {
//       try {
//           const response = await axios.get("/getUserLogin");
//           this.currentUserLogin = response.data;
//       } catch (error) {
//           console.log(error);
//       }
//   },
// },
// });
// app.component('chat-layout', ChatLayout)
app.config.globalProperties.$axios = axios;
const vuetify = createVuetify({
    components,
    directives,
  })

app.use(router);
app.use(store);
app.use(vuetify);
app.mount('#app');