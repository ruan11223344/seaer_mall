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
                },
                {
                    path: 'article',
                    name: 'article',
                    meta: [ '文章管理', '系统文章' ],
                    component: () => import('./views/Article')
                },
                {
                    path: 'agreement',
                    name: 'agreement',
                    meta: [ '文章管理', '会员协议' ],
                    component: () => import('./views/Agreement')
                },
                {
                    path: 'advertisement',
                    name: 'advertisement',
                    component: () => import('./views/Advertisement'),
                    children: [
                        {
                            path: 'home',
                            name: 'home',
                            meta: [ '广告管理', '首页广告' ],
                            component: () => import('./views/Advertisement/Home')
                        },
                        {
                            path: 'edit',
                            name: 'edit',
                            meta: [ '广告管理', '首页广告' ],
                            component: () => import('./views/Advertisement/Edit')
                        }
                    ]
                },
                {
                    path: 'bulletin',
                    name: 'bulletin',
                    meta: [ '系统公告', '系统公告' ],
                    component: () => import('./views/Bulletin')
                },
                {
                    path: 'feedback',
                    name: 'feedback',
                    meta: [ '意见反馈', '反馈信息' ],
                    component: () => import('./views/Feedback')
                },
                { // 消息
                    path: 'news',
                    name: 'news',
                    meta: [ '消息' ],
                    component: () => import('./views/News/index.vue')
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