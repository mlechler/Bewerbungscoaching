
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
<<<<<<< HEAD
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
=======
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
>>>>>>> 0d3881453ca30bc1ffe46f8b6d106b3478da9966
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});
