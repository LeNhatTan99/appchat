
import store from "../store";
  export default function auth({ next }) {
    if (!store.getters['authenticated']) {
      return next({
        name: 'user/login',
      });
    }
  
    return next();
  }

  