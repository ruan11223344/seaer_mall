import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

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
