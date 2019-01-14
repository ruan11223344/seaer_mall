import Cookies from 'js-cookie'

// 配置cookie的方法
const TokenKey = 'afriby-token'

export default {
    getCookies() {
        return Cookies.get(TokenKey)
    },
    setCookies(value) {
        return Cookies.set(TokenKey, value)
    },
    removeCookies() {
        return Cookies.remove(TokenKey)
    }
}