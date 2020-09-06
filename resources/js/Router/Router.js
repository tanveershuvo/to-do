import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Login from '../components/Login/login.vue'
import Signup from '../components/SignUp/signup.vue'
import Home from '../components/Home.vue'
const routes = [
     { path: '/login', component: Login },
     { path: '/signup', component: Signup },
     { path: '/', component: Home },
]
const router = new VueRouter({
    routes, // short for `routes: routes`
    hashbang:false,
    mode:'history'
})
export default router
