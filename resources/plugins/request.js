import axios from "axios";
import Cookies from 'js-cookie';

const apiUrl = 'http://127.0.0.1:8000' + '/api/';

export default {
    getHeader(role) {
        let token = Cookies.get(`token_${role}`);
        return axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    },

    get(url, role) {
        return axios.get(apiUrl + url, this.getHeader(role));
    },

    post(url, data, role) {
        return axios.post(apiUrl + url, data, {
            headers: {
                'Authorization': this.getHeader(role),
                'content-type': 'multipart/form-data'
            }
        });
    },
    postNormal(url, data, role) {
        return axios.post(apiUrl + url, data, {
            headers: {
                'Authorization': this.getHeader(role),
            }
        });
    },
    put(url, data, role, params) {
        return axios.put(apiUrl + url, data, {
             headers: {
                'Authorization': this.getHeader(role),
        }, params: params });
    },
    delete(url, role) {
        return axios.delete(apiUrl + url, this.getHeader(role));
    },

    checkLogin(role) {
        let token = Cookies.get(`token_${role}`);
        if (token == null) {
            return false;
        } else return true;
    }

}