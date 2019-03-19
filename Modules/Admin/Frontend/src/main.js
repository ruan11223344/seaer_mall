import '@babel/polyfill'
import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import PutRequest from '@/utils/putRequest.js'
import GetRequest from '@/utils/getRequest.js'
import Auth from '@/utils/auth.js'
import VueLazyLoad from 'vue-lazyload'

Vue.prototype.$GetRequest = GetRequest
Vue.prototype.$PutRequest = PutRequest
Vue.prototype.$Auth = Auth

// 清除默认样式
import "@/style/reset.css"

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import './style/element-variables.scss'

Vue.use(ElementUI).use(VueLazyLoad)


Vue.config.productionTip = true

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
