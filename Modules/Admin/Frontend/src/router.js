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
            component: () => import('./views'),
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
                },
                {
                    path: 'admin',
                    name: 'admin',
                    component: () => import('./views/Admin'),
                    children: [
                        {
                            path: 'home',
                            name: 'home',
                            meta: [ '用户管理', '管理员' ],
                            component: () => import('./views/Admin/Admin'),
                        },
                        {
                            path: 'add',
                            name: 'add',
                            meta: [ '用户管理', '管理员', '新增' ],
                            component: () => import('./views/Admin/Add')
                        },
                        {
                            path: 'jurisdiction',
                            name: 'jurisdiction',
                            meta: [ '用户管理', '管理员', '新增' ],
                            component: () => import('./views/Admin/Jurisdiction')
                        }
                    ]
                },
                {
                    path: 'allproducts',
                    name: 'allproducts',
                    meta: [ '商品管理', '全部商品' ],
                    component: () => import('./views/AllProducts')
                },
                {
                    path: 'wait',
                    name: 'wait',
                    meta: [ '商品管理', '待审核商品' ],
                    component: () => import('./views/Wait')
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