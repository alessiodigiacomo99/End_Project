import VueRouter from 'vue-router'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.use(VueRouter); 

import App from './views/AppComponent'
import Header from './components/HeaderComponent'
import Search from './views/SearchComponent'
import Searchid from './components/ShowComponent'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'header',
            component: Header
        },
        {   
            path: '/search',
            name: 'search',
            component: Search,
        },
        {   
            path: '/search/:id',
            component: Searchid,
        },
    ],
});


/** 
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app-component', require('./views/AppComponent.vue').default);
Vue.component('header-component', require('./components/HeaderComponent.vue').default);
Vue.component('navbar-component', require('./components/NavbarComponent.vue').default);
Vue.component('main-component', require('./components/MainComponent.vue').default);
Vue.component('footer-component', require('./components/FooterComponent.vue').default);
Vue.component('show-component', require('./components/ShowComponent.vue').default);
Vue.component('navbarsearch-component', require('./components/NavbarSearchComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
