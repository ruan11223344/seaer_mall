import Cookies from 'js-cookie'

// 配置cookie的方法
const TokenKey = 'afriby-token'

const RefreshKey = 'refresh-token'

export default {
    getCookies() {
        return Cookies.get(TokenKey)
    },
    setCookies(value) {
        return Cookies.set(TokenKey, value)
    },
    refreshCookies(value) {
        return Cookies.set(RefreshKey, value)
    },
    removeCookies() {
        return Cookies.remove(TokenKey)
    }
}