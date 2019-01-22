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
          // 国旗
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
          // 设置
        {
          path: 'set',
          component: () => import("./views/Inquiry/Set/index.vue")        
        } 
      ]
    },
    {
      // 公司首页
      path: "/company",
      name: "company ",
      component: () => import("./views/Company/index.vue"),
      children: [
        {
          // 首页
          path: "home",
          component: () => import("./views/Company/Home/index.vue")
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
