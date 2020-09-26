// import Vue from 'vue';
import axios from 'axios';
console.log(process.env)
const client = axios.create({
    baseURL: process.env.VUE_APP_API_URL
})

export default client