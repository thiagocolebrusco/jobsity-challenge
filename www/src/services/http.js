// import Vue from 'vue';
import axios from 'axios';
const client = axios.create({
    baseURL: process.env.VUE_APP_API_URL
})

client.interceptors.request.use(config => {
    if (localStorage.getItem("token")) {
        config.headers.common.Authorization = `Bearer ${localStorage.getItem("token")}`;
    }
  
    return config;
  }, error => {
    return Promise.reject(error);
});

export default client