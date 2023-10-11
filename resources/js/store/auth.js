import axios from 'axios';
import Cookies from 'js-cookie';
import router from '../route';
import Request from "../../plugins/request.js";
import Toast from '../nofitication/toast';

export default {
  state: {
      authenticated: {
        user: false,
        admin: false,
      },
      account: {
        user: {},
        admin: {}
      },
      token_user: Cookies.get('token_user') || null,
      token_admin: Cookies.get('token_admin') || null,
      roles: {
        admin: false,
        user: false,
      },
  },
  mutations: {
    SET_AUTHENTICATED(state, {value, role}) {
        if (role && role == 'admin') {
          state.authenticated.admin = value;
        }
        if (role && role == 'user') {
          state.authenticated.user = value;
        }
    },
    SET_ACCOUNT(state, {value, account , role}) {
      if (role && role == 'admin') {
        state.account.admin = account;
        state.roles.admin = value;
      }
      if (role && role == 'user') {
        state.account.user = account;
        state.roles.user = value;
      }
    },
    SET_TOKEN(state, { token, role, remember }) {
      Cookies.set(`token_${role}`, token, { expires: remember ? 365 : null });
      if (role == 'admin') {
        state.token_admin = token;
      }
      if (role == 'user') {
        state.token_user = token;
      }
    },
    CLEAR_TOKEN(state, role) {
      Cookies.remove(`token_${role}`);
      if (role == 'admin') {
        state.token_admin = null;
        state.token_user = Cookies.get('token_user') || null;
      }
      if (role == 'user') {
        state.token_user = null;
        state.token_admin = Cookies.get('token_admin') || null;
      }
    },
  },
  actions: {
    async login({commit}, payload) {
        try {
            await axios
              .post('/api/user/login', {
                email: payload.email,
                password: payload.password,
                remember: payload.remember,
              })
              .then((response) => {
                const token = response.data.token
                const account = response.data.account
                const role = response.data.type
                commit('SET_AUTHENTICATED', {value: true, role});
                commit('SET_ACCOUNT', {value: true, account, role});
                commit('SET_TOKEN', { token, role , remember: null });

                Toast.showToast('success', response.data.message);

                if(response.data.type == 'admin') {
                  router.push({ name: 'adminDashboard' });                 
                }
                else  router.push({ name: 'userDashboard' });
              })
              .catch((err) => {
                throw err.response;
              });
          } catch (e) {
            Toast.showToast('error', e.data.message);
          }
    },

    async logout({ commit }, role) {
      await Request.post('user/logout', null, role);
      commit('SET_ACCOUNT', {value: false, account: {}, role});
      commit('SET_AUTHENTICATED',  {value: false, role});
      commit('CLEAR_TOKEN', role);
      Toast.showToast('success', 'Đăng xuất thành công');
      router.push({ name: 'userLogin' });
    },
    async currentUser({ commit }, role) {
        try {
            await Request.get('user/info', role)
              .then(response => {
                const userInfo = response.data.data;
                commit('SET_ACCOUNT', userInfo);
                commit('SET_AUTHENTICATED',  {value: true, role})
              })
              .catch((err) => {
                throw err.response;
              });
        } catch (error) {
          commit('SET_ACCOUNT', {})
          commit('SET_AUTHENTICATED',  {value: false, role})
        }
      },
  },
  getters: {
    authenticated(state) {
        return state.authenticated
    },
    account(state) {
        return state.account
    },
    token_user(state) {
      const token = state.token_user || Cookies.get('token_user');
      return token
    },
    token_admin(state) {
      const token = state.token_admin || Cookies.get('token_admin');
      return token
    },
    roles(state) {
      return state.roles;
    },
  }
};
