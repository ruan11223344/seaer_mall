import axios from 'axios'
import auth from '../utils/auth'

// 创建axios实例
const service = axios.create({
  baseURL: 'http://www.seaer.local/api', // api 的 base_url
  timeout: 15000, // 请求超时时间
  headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }
})

// request拦截器
service.interceptors.request.use(
  config => {
    // token 存在则携带token
    if(auth.getCookies()) {
      const token = auth.getCookies()
      config.headers['Authorization'] = 'Bearer ' + token;
    }

    return config
  },
  error => {
    // Do something with request error
    console.log(error) // for debug
    Promise.reject(error)
  }
)

// response 拦截器
service.interceptors.response.use(
  response =>{
    // const res = response.data
    // //这里面可以设置自定义的返回错误
    // if (res.code === 40001) {
    //   //token已过期的状态码
    //   removeToken()
    //   store.commit('SET_TOKEN', '')
    //   location.reload()
    // } else {
      return response.data
    // }
  },
  error => {
    console.log('err' + error) // for debug
    return Promise.reject(error)
  }
)

export default service