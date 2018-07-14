
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Tooltip from 'vue-directive-tooltip';
import 'vue-directive-tooltip/css/index.css';
Vue.use(Tooltip);

$(".toggle-icon").click(function() {
  $('.ico').toggleClass("pushed");
});

import CxltToastr from 'cxlt-vue2-toastr'

Vue.use(CxltToastr, {
  position: 'bottom right',
  showDuration: 1000,
  timeOut: 3000
})


Vue.component('thread', require('./components/Thread'));
Vue.component('new-thread', require('./components/NewThread'));
Vue.component('channel-password', require('./components/ChannelPassword'));

const app = new Vue({
    el: '#app'
});
