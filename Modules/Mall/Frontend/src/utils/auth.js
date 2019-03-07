import Cookies from 'js-cookie'

// 配置cookie的方法
const TokenKey = 'afriby-token'

const RefreshKey = 'refresh-token'

const user = 'User_info'

export default {
    getCookies() {
        return Cookies.get(TokenKey)
    },
    getRefCookies() {
        return Cookies.get(RefreshKey)
    },
    setCookies(value) {
        return Cookies.set(TokenKey, value)
    },
    refreshCookies(value) {
        return Cookies.set(RefreshKey, value)
    },
    removeCookies() {
        return Cookies.remove(TokenKey)
    },
    removeRefreshKey() {
        return Cookies.remove(RefreshKey)
    },
    setSessionStorage(value) {
        const json = JSON.stringify(value)
        return sessionStorage.setItem(user, json)
    },
    getSessionStorage() {
        const data = JSON.parse(sessionStorage.getItem(user))
        return data
    }
}