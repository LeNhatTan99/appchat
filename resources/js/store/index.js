import { createStore } from 'vuex';
import sharedMutations from 'vuex-shared-mutations';
import persistedState from 'vuex-persistedstate';
import auth from '../store/auth'

export default createStore({
  state: {
    friendRequestAccepted: false,
  },
  mutations: {
    setFriendRequestAccepted(state, payload) {
      state.friendRequestAccepted = payload;
    },
  },
  actions: {
    //
  },
  modules: {
    auth,
  },
  plugins: [
    sharedMutations({
      predicate: ['SET_ACCOUNT', 'SET_AUTHENTICATED', 'SET_TOKEN'],
    }),
    persistedState({
      storage: window.sessionStorage,
    }),
  ],
});