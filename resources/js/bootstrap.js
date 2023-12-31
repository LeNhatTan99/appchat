import _ from 'lodash';
window._ = _;

import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo"
import Cookies from 'js-cookie';

try {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: `${window.location.protocol}//${window.location.hostname}:6001`,
        auth: {
            headers: {
                Authorization: 'Bearer ' + Cookies.get('token_user')
            }
        }
        
    });
} catch (error) {
    console.log('Lỗi Echo server');
    console.log(error);
}
