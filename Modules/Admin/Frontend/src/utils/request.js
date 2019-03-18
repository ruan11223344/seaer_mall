import axios from 'axios'
import auth from '../utils/auth'
import router from '../router'
import putRequest from './putRequest'

function refreshToken() {
    const token = auth.getCookies()
    const refToken = auth.getRefCookies()
    
    if(token && refToken) {
        // upData.upRegToken(refToken)
        //     .then((res) => {
        //         auth.removeCookies()
        //         auth.removeRefreshKey()
        //         auth.setCookies(res.data.access_token)
        //         auth.refreshCookies(res.data.refresh_token)
        //     })
    }else {
        router.push('/login')
    }
}

// 创建axios实例
const service = axios.create({
    baseURL: 'https://admin.happyhub2018.com/api', // api 的 base_url
    timeout: 15000, // 请求超时时间
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }
})

// request拦截器
service.interceptors.request.use(
    config => {
        // token 存在则携带token
        if (auth.getCookies()) {
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
    response => {
        if(response.data.code == 401) {
            refreshToken()
        }else {
            return response.data
        }
        return response.data
    },
    error => {
        console.log(error) // for debug
        console.log('报错了');
        // router.push('/login')
        return Promise.reject(error)
    }
)

export default service