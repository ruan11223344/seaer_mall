import Cookies from 'js-cookie'

// 配置cookie的方法
const TokenKey = 'afriby-token'

const RefreshKey = 'refresh-token'

class Auth {
    getCookies() {
        return Cookies.get(TokenKey)
    }

    getRefCookies() {
        return Cookies.get(RefreshKey)
    }

    setCookies(value) {
        return Cookies.set(TokenKey, value)
    }

    refreshCookies(value) {
        return Cookies.set(RefreshKey, value)
    }

    removeCookies() {
        return Cookies.remove(TokenKey)
    }

    removeRefreshKey() {
        return Cookies.remove(RefreshKey)
    }
}

export default new Auth()