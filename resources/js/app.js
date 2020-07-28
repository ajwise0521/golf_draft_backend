/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import vueRouter from 'vue-router';

window.Vue = require('vue');
window.Vuex = require('vuex');
Vue.use(Vuex);
window.vueStore = new Vuex.Store({
    modules: {
        auth: require('./store/auth'),
    },
});
Vue.use(vueRouter);

// Vue.component('leagues', require('./components/golf/leagues'))

let toastr = window.toastr = require('toastr');

toastr.options = {
    "closeButton": true,
    "positionClass": "toast-bottom-right",
    "onclick": null,
    "showDuration": "150",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

window.errorAndRefresh = function(error){
    toastr.warning(error + ' Refreshing the page.');
    setTimeout(function(){
        window.location.reload();
    }, 2000);
};

window.eventBus = new Vue();

const routes = [
	{ path: '/login', component: require('./components/auth/login').default},
    { path: '/logout', component: require('./components/auth/logout').default},
	{ path: '/', component: require('./components/home').default},
	{ path: '/leagues', component: require('./components/golf/leagues').default},
    { path: '/draft', component: require('./components/golf/draft/draft-landing').default},
	{ path: '/draft/:draft_id', component: require('./components/golf/draft/home').default}
];


Vue.component('navbar', require('./components/navbar.vue').default);
Vue.component('app-container', require('./components/app-container.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new vueRouter({
	routes
})

router.beforeEach((to, from, next) => {
    if (!vueStore.state.auth.isAuthenticated && window.localStorage.getItem('draftPage.auth') !== null) {
        vueStore.commit('auth/authenticate', JSON.parse(window.localStorage.getItem('draftPage.auth')));
    }

    if ((!vueStore.state.auth.isAuthenticated && !to.path.includes('login')) ||
        (vueStore.state.auth.isAuthenticated && (vueStore.state.auth.loginTime + vueStore.state.auth.expiresIn) < Math.floor(Date.now() / 1000))) {
        next('/login');
    } else {
        next();
    }
});

const app = new Vue({
	router,
    vueStore,
    computed: {
        store: function () {
            return vueStore;
        }
    },
}).$mount('#app');
