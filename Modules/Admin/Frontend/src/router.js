import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            name: 'home',
            redirect: '/home',
            component: () => import('./views/Main'),
            children: [
                {
                    path: '/home',
                    name: 'home',
                    meta: [ '首页' ],
                    component: () => import('./views/Home'),
                },
                {
                    path: 'user',
                    name: 'user',
                    meta: [ '用户管理', '用户' ],
                    component: () => import('./views/User')
                },
                {
                    path: 'business',
                    name: 'business',
                    meta: [ '用户管理', '商家' ],
                    component: () => import('./views/Business')
                }
            ]
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('./views/Login')
        }
    ]
})

export default router