
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import App from './App.vue';
import ProductDetail from './components/product/Detail.vue';
import ProductListing from './components/product/Listing.vue';

/**
 * Require bootstrap
 */
import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
require('./bootstrap');

/**
 * Routes
 */
const routes = [
    {
        path: '/',
        name: 'ProductListing',
        component: ProductListing
    },
    {
        path: '/products',
        name: 'ProductListing',
        component: ProductListing
    },
    {
        path: '/products/:id',
        name: 'ProductDetail',
        component: ProductDetail
    }
];

/**
 * Register components
 */
Vue.component('pagination', require('laravel-vue-pagination'));

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

new Vue(Vue.util.extend({ router }, App)).$mount('#app');