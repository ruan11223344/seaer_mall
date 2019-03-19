import Vue from 'vue'
import Router from 'vue-router'
import auth from './utils/auth'


Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            redirect: 'home',
            component: () => import('./views'),
            children: [
                {
                    path: 'home',
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
                { // 用户管理----商家
                    path: 'business',
                    name: 'business',
                    meta: [ '用户管理', '商家' ],
                    component: () => import('./views/Business')
                },
                { // 用户管理----管理员
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
                { // 商品管理
                    path: 'products',
                    name: 'products',
                    component: () => import('./views/Products'),
                    children: [
                        {
                            path: 'allproducts',
                            name: 'allproducts',
                            meta: [ '商品管理', '全部商品' ],
                            component: () => import('./views/Products/AllProducts')
                        },
                        {
                            path: 'wait',
                            name: 'wait',
                            meta: [ '商品管理', '待审核商品' ],
                            component: () => import('./views/Products/Wait')
                        },
                        {
                            path: 'details',
                            name: 'details',
                            meta: [ '商品管理', '全部商品', '商品详情' ],
                            component: () => import('./views/Products/Details')
                        }
                    ]
                },
                { // 文章管理
                    path: 'article',
                    name: 'article',
                    component: () => import('./views/Article'),
                    children: [
                        {
                            path: 'systemarticle',
                            name: 'systemarticle',
                            meta: [ '文章管理', '系统文章' ],
                            component: () => import('./views/Article/System')
                        },
                        {
                            path: 'agreement',
                            name: 'agreement',
                            meta: [ '文章管理', '系统文章' ],
                            component: () => import('./views/Article/Agreement')
                        },
                        {
                            path: 'publish',
                            name: 'publish',
                            meta: [ '文章管理', '系统文章', '新增' ],
                            component: () => import('./views/Article/Publish')
                        },
                        {
                            path: 'edit',
                            name: 'edit',
                            meta: [ '文章管理', '系统文章', '编辑' ],
                            component: () => import('./views/Article/Edit')
                        }
                    ]
                },
                { // 广告管理
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
                        },
                        {
                            path: 'productedit',
                            name: 'ProductEdit',
                            meta: [ '广告管理', '首页广告', '选择商品' ],
                            component: () => import('./views/Advertisement/ProductEdit')
                        }
                    ]
                },
                { // 系统公告
                    path: 'bulletin',
                    name: 'bulletin',
                    meta: [ '系统公告', '系统公告' ],
                    component: () => import('./views/Bulletin')
                },
                { // 意见反馈
                    path: 'opinion',
                    name: 'opinion',
                    component: () => import('./views/Opinion'),
                    children: [
                        {
                            path: 'feedback',
                            name: 'feedback',
                            meta: [ '意见反馈', '反馈信息' ],
                            component: () => import('./views/Opinion/Feedback')
                        },
                        {
                            path: 'details',
                            name: 'details',
                            meta: [ '意见反馈', '反馈信息', '详情' ],
                            component: () => import('./views/Opinion/Details')
                        }
                    ]
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

const arr = ['/login']

router.beforeEach((to, from, next) => {
    const { path } = to
    const TokenKey = auth.getCookies()
    const RefreshKey = auth.getRefCookies()
    
    if(arr.includes(path)) {
        if(TokenKey && RefreshKey) {
            next(from.path)
        }else {
            next('/login')
        }
    }else {

        if(TokenKey && RefreshKey) {
            next()
        }else {
            next('/login')
        }
    }
})

export default router