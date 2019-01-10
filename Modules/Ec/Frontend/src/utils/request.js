import axios from 'axios'

// 创建axios实例

const service = axios.create({
  baseURL: 'http://yapi.demo.qunar.com/mock/32239', // api 的 base_url
  timeout: 15000 // 请求超时时间
})

// request拦截器
service.interceptors.request.use(
  config => {

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
      return response
    // }
  },
  error => {
    console.log('err' + error) // for debug
    return Promise.reject(error)
  }
)

export default service