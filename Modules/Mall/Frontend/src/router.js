import Vue from 'vue'
import Router from 'vue-router'
import Nprogress from 'nprogress'
import 'nprogress/nprogress.css'
import auth from "@/utils/auth"

Vue.use(Router)

// 路由
const newRouter = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: '/home'
        },
        {
            path: '/home',
            name: 'home',
            component: () => import('./views/Home')
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('./views/Login'),
            beforeEnter: (to, from, next) => {
                const token = auth.getCookies()

                if(token) {
                    return next(from.path)
                }

                return next()
            }
        },
        {
            path: '/registered', // 注册账户
            component: () => import('./views/Registered'),
            children: [
                {
                    path: 'one', // 第一步
                    component: () => import('./views/Registered/One')
                },
                {
                    path: 'two', // 第二步
                    component: () => import('./views/Registered/Two')
                },
                {
                    path: 'three',
                    component: () => import('./views/Registered/Three')
                },
                { // 注册完成
                    path: 'complete',
                    component: () => import('./views/Registered/Complete')
                }
            ]
        },
        {
            path: '/reset', // 重置密码
            component: () => import('./views/ResetPass'),
            children: [
                {
                    path: 'pass',
                    component: () => import('./views/ResetPass/Pass')
                },
                {
                    path: 'find',
                    component: () => import('./views/ResetPass/Find')
                }
            ]
        },
        {
            path: '/goods',
            name: 'goods',
            component: () => import('./views/Goods/index.vue'),
            children: [
                // 店铺列表
                {
                    path: 'companylist',
                    component: () => import('./views/Goods/CompanyList/index.vue')
                },
                // 商品列表
                {
                    path: 'list',
                    component: () => import('./views/Goods/List/index.vue')
                },
                // 商品详细信息
                {
                    path: 'details',
                    component: () => import('./views/Goods/Details/index.vue')
                },
                // 咨询
                {
                    path: 'consulting',
                    component: () => import('./views/Goods/Consulting/index.vue')
                },
                // 询盘成功
                {
                    path: 'success',
                    component: () => import('./views/Goods/Success/index.vue')
                }
            ]
        },
        {
            // 询盘列表
            path: "/inquiryList",
            name: "inquiry",
            beforeEnter(to, from, next) {
                const TokenKey = auth.getCookies()
                if(TokenKey) {
                    next()
                }else {
                    next('/login')
                }
            },
            component: () => import("./views/Inquiry/index.vue"),
            children: [
                {
                    // 发件箱
                    path: "send",
                    component: () => import("./views/Inquiry/Send/index.vue")
                },
                {
                    // 收件箱
                    path: "inbox",
                    component: () => import("./views/Inquiry/Inbox/index.vue")
                },
                { // 收藏
                    path: "collection",
                    component: () => import("./views/Inquiry/Collection/index.vue")
                },
                {
                    // 标记
                    path: "flag",
                    component: () => import("./views/Inquiry/Flag/index.vue")
                },
                { // 读
                    path: "read",
                    component: () => import("./views/Inquiry/Read/index.vue")
                },
                {
                    // 回复
                    path: "reply",
                    component: () => import("./views/Inquiry/Reply/index.vue")
                },
                {
                    // 垃圾邮件
                    path: "spam",
                    component: () => import("./views/Inquiry/Spam/index.vue")
                },
                { // 删除
                    path: 'del',
                    component: () => import("./views/Inquiry/Delete/index.vue")
                },
                { // 上传头像
                    path: 'picture',
                    component: () => import("./views/Inquiry/Picture/index.vue")
                },
                { // 账户
                    path: 'account',
                    component: () => import("./views/Inquiry/Account/index.vue"),
                    children: [
                        {
                            // 账户信息
                            path: 'accountinfo',
                            component: () => import("./views/Inquiry/Account/AccountInfo/index.vue")
                        },
                        {
                            // 账户信息编辑
                            path: 'accountedit',
                            component: () => import("./views/Inquiry/Account/AccountEdit/index.vue")
                        }
                    ]
                },
                { // 公司
                    path: 'company',
                    component: () => import("./views/Inquiry/Company/index.vue"),
                    children: [
                        { // 公司信息
                            path: 'companyinfo',
                            component: () => import("./views/Inquiry/Company/CompanyInfo/index.vue")
                        },
                        { // 公司信息编辑
                            path: 'companyedit',
                            component: () => import("./views/Inquiry/Company/CompanyEdit/index.vue")
                        },
                    ]
                },
                { // 商品管理
                    path: 'commodity',
                    component: () => import("./views/Inquiry/Commodity/index.vue"),
                    children: [
                        { //商品操作
                            path: 'operation',
                            component: () => import("./views/Inquiry/Commodity/Operation/index.vue")
                        },
                        { // 商品编辑
                            path: 'edit',
                            component: () => import("./views/Inquiry/Commodity/Edit/index.vue")
                        }
                    ]
                },
                { // 上传商品
                    path: 'uploadroot',
                    component: () => import("./views/Inquiry/UpdateRoot/index.vue"),
                    children: [
                        { // 上传商品
                            path: 'uploadproduct',
                            component: () => import("./views/Inquiry/UpdateRoot/Update/index.vue")
                        },
                        { // 上传商品----详细信息
                            path: 'uploadinfo',
                            component: () => import("./views/Inquiry/UpdateRoot/UpdateInfo/index.vue")
                        },
                        { // 审核
                            path: 'examine',
                            component: () => import("./views/Inquiry/UpdateRoot/Examine/index.vue")
                        },
                        { // 上传前审核
                            path: 'tips',
                            component: () => import("./views/Inquiry/UpdateRoot/Tips/index.vue")
                        },
                    ]
                },
                { // 相册
                    path: 'album',
                    component: () => import("./views/Inquiry/Album/index.vue"),
                    children: [
                        {
                            // 管理相册
                            path: "administration",
                            component: () => import("./views/Inquiry/Album/Administration/index.vue")
                        },
                        {
                            // 相册列表
                            path: "listalbum",
                            component: () => import("./views/Inquiry/Album/ListAlbum/index.vue")
                        },
                        {
                            // 预览图片信息
                            path: "PicturePreview",
                            component: () => import("./views/Inquiry/Album/PicturePreview/index.vue")
                        }
                    ]
                },
                { // 产品分组
                    path: 'SortProducts',
                    component: () => import("./views/Inquiry/Sort/index.vue")
                },
                { // 店铺管理
                    path: 'management',
                    component: () => import("./views/Inquiry/Management/index.vue"),
                    children: [
                        { // 店铺设置
                            path: 'bannerset',
                            component: () => import("./views/Inquiry/Management/BannerSet/index.vue")
                        },
                        {
                            // 商店动态
                            path: 'dynamics',
                            component: () => import("./views/Inquiry/Management/Dynamics/index.vue")
                        }
                    ]
                },
                { // 账户中心
                    path: 'personalpenter',
                    component: () => import("./views/Inquiry/PersonalCenter/index.vue")
                },
                { // 设置
                    path: 'set',
                    component: () => import("./views/Inquiry/Set/index.vue")
                },
                { // 修改密码
                    path: 'changepass',
                    component: () => import("./views/Inquiry/ChangePassword/index.vue")
                },
                { // 咨询
                    path: 'notice',
                    component: () => import("./views/Inquiry/Notice/index.vue")
                }
            ]
        },
        {
            // 公司首页
            // 店铺
            path: "/company",
            name: "company ",
            component: () => import("./views/Company/index.vue"),
            children: [
                {
                    // 首页
                    path: "home",
                    component: () => import("./views/Company/Home/index.vue")
                },
                {
                    // 所有商品 商品分组
                    path: "all",
                    component: () => import("./views/Company/AllCommodity/index.vue")
                },
                {
                    // 联系方式
                    path: "contact",
                    component: () => import("./views/Company/Contact/index.vue")
                },
                {
                    // 关于我们
                    path: "profile",
                    component: () => import("./views/Company/Profile/index.vue")
                }
            ]
        },
        { // 帮助
            path: '/help',
            component: () => import('./views/Help/index.vue')
        },
        { // 公告
            path: '/notice',
            component: () => import('./views/Notice/index.vue')
        },
        { // 关于我们
            path: '/about',
            component: () => import('./views/About/index.vue')
        },
        {
            path: '*',
            component: () => import("./views/404/index.vue")
        }
    ]
})

// 导航开始前
newRouter.beforeEach((to, from, next) => {
    Nprogress.start()
    next()
})

// 导航成功后
newRouter.afterEach(() => {
    Nprogress.done()
})

export default newRouter
