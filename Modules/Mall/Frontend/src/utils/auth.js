import Cookies from 'js-cookie'

// 配置cookie的方法
const TokenKey = 'afriby-token'
const RefreshKey = 'refresh-token'
const user = 'User_info'
const Product = 'Product_All'

function aesEncrypt(data) {
    let crypted = ''
    for (let index = 0; index < data.length; index++) {
        crypted += data.charCodeAt(index) + ','
    }
    return crypted;
}

function aesDecrypt(arr) {
    const encrypted = arr.split(',')
    let decrypted = ''
    for (let index = 0; index < encrypted.length; index++) {
        if(index != encrypted.length - 1) {
            decrypted += String.fromCharCode(encrypted[index])
        }
    }
    return decrypted;
}

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
        return sessionStorage.setItem(user, aesEncrypt(json))
    },
    getSessionStorage() {
        const v = sessionStorage.getItem(user)
        if(!v) return
        const data = JSON.parse(aesDecrypt(v))
        return data
    },
    removeSessionStorage() {
        // 从 sessionStorage 删除保存的数据
        return sessionStorage.removeItem(user);
    },
    // 搜索的商品数据
    getProductAllStorage() {
        const v = sessionStorage.getItem(Product)
        if(!v) return
        const data = JSON.parse(aesDecrypt(v))
        return data
    },
    setProductAllStorage(value) {
        const json = JSON.stringify(value)
        return sessionStorage.setItem(Product, aesEncrypt(json))
    },

}