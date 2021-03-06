import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Login from '../components/Auth/login.vue'
import Logout from '../components/Auth/logout.vue'
import Signup from '../components/Auth/signup.vue'
import Home from '../components/Home.vue'
const routes = [
     { path: '/', component: Login , name:'Login'},
     { path: '/signup', component: Signup ,name:'SignUp'},
     { path: '/home', component: Home , name:'Home'},
     { path: '/logout', component: Logout , name:'Logout'},
]
const router = new VueRouter({
    routes, // short for `routes: routes`
    hashbang:false,
    mode:'history'
})
export default router
