import '@babel/polyfill'
import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import putRequest from '@/utils/putRequest.js'
import getRequest from '@/utils/getRequest.js'

Vue.prototype.$getRequest = getRequest
Vue.prototype.$putRequest = putRequest

// 清除默认样式
import "@/style/reset.css"

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import './style/element-variables.scss'

Vue.use(ElementUI)


Vue.config.productionTip = true

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
