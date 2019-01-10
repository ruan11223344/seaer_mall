import Vue from 'vue'
import Router from 'vue-router'
import Nprogress from 'nprogress'
import 'nprogress/nprogress.css'

import details from './views/Goods/Details/index.vue'

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
      component: () => import('./views/Login')
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
      ]      
    },
    {
      path: '/reset', // 重置密码
      component: () => import('./views/ResetPass'),
      children: [
        {
          path: 'one', // 第一步
          component: () => import('./views/ResetPass/One')
        },
        {
          path: 'two', // 第二步
          component: () => import('./views/ResetPass/Two')
        },
        {
          path:'three', // 第三步
          component: () => import('./views/ResetPass/Three')
        },
        {
          path: 'four', // 第四步
          component: () => import('./views/ResetPass/Four')
        }
      ]
    },
    {
      path: '/goods',
      name: 'goods',
      component: () => import('./views/Goods/index.vue'),
      children: [
        {
          path: 'list',
          component: () => import('./views/Goods/List/index.vue')
        },
        {
          path: 'details/:id',
          // path: 'details',
          // component: () => import('./views/Goods/Details/index.vue')
          component: details
        },
        // 咨询
        {
          path: 'consulting',
          component: () => import('./views/Goods/Consulting/index.vue')
        }
      ]
    },
    {
      // 询盘列表
      path: "/inquiryList",
      name: "inquiry",
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
        }
      ]
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
