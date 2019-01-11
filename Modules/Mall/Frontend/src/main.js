import Vue from 'vue'
import App from './App.vue'
import router from './router'

// 清除默认样式
import "@/assets/css/reset.css"

import store from './store'
import iView from 'iview'
import locale from 'iview/dist/locale/en-US';
import 'iview/dist/styles/iview.css'

// ajax
import request from '@/utils/request.js'
import VueLazyLoad from 'vue-lazyload'
// 引入验证插件
import verify from "vue-verify-plugin"
// 自定义验证规则
import myRules from '@/utils/verify.js'
// 注册自定义验证
Vue.use(verify, {
  rules: myRules,
  blur: true  // 失去焦点进行判断
})

// 挂载axios
Vue.prototype.$request = request

// 注册 iView
Vue.use(iView, {
  transfer: true,
  size: 'large',
  locale
}).use(VueLazyLoad)

Vue.config.productionTip = false

//认证组件 详细参考 https://laravelacademy.org/post/8298.html
Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue')
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue')
);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
