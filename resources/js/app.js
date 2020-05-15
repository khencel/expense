/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { Form, HasError } from "vform";

window.token = document.getElementsByName('user-token')[0].content;

window.Form = Form;
window.Vue = require('vue');
window.Fire = new Vue();

Vue.component(HasError.name, HasError);

Vue.component('user-dashboard', require('./components/DashboardComponent.vue').default);
Vue.component('change-password', require('./components/ChangePasswordComponent.vue').default);


Vue.component('user-role', require('./components/user/RoleComponent.vue').default);
Vue.component('user-users', require('./components/user/UserComponent.vue').default);

Vue.component('expense-category', require('./components/expense/CategoryComponent.vue').default);
Vue.component('expense-expenses', require('./components/expense/ExpenseComponent.vue').default);



const app = new Vue({
    el: '#app',
});
