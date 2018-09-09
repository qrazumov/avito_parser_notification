
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

let Vuetify = require('vuetify');
import 'vuetify/dist/vuetify.min.css'
import 'nprogress/nprogress.css'

import VueRouter from 'vue-router'
import NProgress from 'nprogress'


import index from './components/IndexComponent.vue'
import filters from './components/FilterComponent.vue'
import App from './components/App.vue'


const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home',
            name: 'index',
            component: index
        },
        {
            path: '/home/filters',
            name: 'filters',
            component: filters,
        },
    ],
});

router.beforeEach((to, from, next) => {
    NProgress.start()
    NProgress.set(0.1)
    next()
})
router.afterEach(() => {
    setTimeout(() => NProgress.done(), 500)
})

const calculatePercentage = (loaded, total) => (Math.floor(loaded * 1.0) / total)

const setupUpdateProgress = () => {
    axios.defaults.onDownloadProgress = e => {
        const percentage = calculatePercentage(e.loaded, e.total)
        NProgress.set(percentage)
    }
}

const setupStopProgress = () => {
    axios.interceptors.response.use(response => {
        NProgress.done(true)
        return response
    })
}

    setupUpdateProgress()
    setupStopProgress()







Vue.use(VueRouter)
Vue.use(Vuetify, { theme: {
        primary: '#2196f3',
        secondary: '#424242',
        accent: '#82B1FF',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107'
    }})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/IndexComponent.vue'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});