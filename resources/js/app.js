/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');
import Vue from 'vue'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('seasonal-player-listing', require('./components/SeasonalPlayerListing.vue').default);
Vue.component('seasonal-player-profile', require('./components/SeasonalPlayerProfile.vue').default);
Vue.component('ranking-history-detail', require('./components/RankingHistoryDetail.vue').default);
Vue.component('ranking-progression-indicator', require('./components/RankingProgressionIndicator.vue').default);
Vue.component('ranking-summaries', require('./components/RankingSummaries.vue').default);
Vue.component('meta-info', require('./components/MetaInfo.vue').default);
Vue.component('ranking-summary-breakdown-tiers', require('./components/RankingSummaryBreakdownTiers.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
