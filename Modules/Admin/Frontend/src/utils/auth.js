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

    getUserCookies() {
        const value = sessionStorage.getItem('user_info')

        return JSON.parse(value)
    }

    setUserCookies(value) {
        const obj = JSON.stringify(value)
        return sessionStorage.setItem('user_info', obj)
    }

    rmUserCookies() {
        return window.sessionStorage.removeItem('user_info')
    }
}

export default new Auth()