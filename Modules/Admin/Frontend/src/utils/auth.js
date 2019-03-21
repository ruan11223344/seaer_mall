import Cookies from 'js-cookie'

// 配置cookie的方法
const TokenKey = 'afriby-token'

const RefreshKey = 'refresh-token'

class Auth {
    getCookies() {
        // return Cookies.get(TokenKey)
        return sessionStorage.getItem(TokenKey)
    }

    getRefCookies() {
        // return Cookies.get(RefreshKey)
        return sessionStorage.getItem(RefreshKey)
    }

    setCookies(value) {
        // return Cookies.set(TokenKey, value)
        return sessionStorage.setItem(TokenKey, value)
    }

    refreshCookies(value) {
        // return Cookies.set(RefreshKey, value)
        return sessionStorage.setItem(RefreshKey, value)
    }

    removeCookies() {
        // return Cookies.remove(TokenKey)
        return window.sessionStorage.removeItem(TokenKey)
    }

    removeRefreshKey() {
        // return Cookies.remove(RefreshKey)
        return window.sessionStorage.removeItem(RefreshKey)
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