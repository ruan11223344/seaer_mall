import Cookies from 'js-cookie'
import crypto from 'crypto'

// 配置cookie的方法
const TokenKey = 'afriby-token'
const RefreshKey = 'refresh-token'
const user = 'User_info'
const Product = 'Product_All'
const Shop_All = 'Shop_All'

// function aesEncrypt(data) {
//     let crypted = ''
//     for (let index = 0; index < data.length; index++) {
//         crypted += data.charCodeAt(index) + ','
//     }
//     return crypted;
// }

// function aesDecrypt(arr) {
//     const encrypted = arr.split(',')
//     let decrypted = ''
//     for (let index = 0; index < encrypted.length; index++) {
//         if(index != encrypted.length - 1) {
//             decrypted += String.fromCharCode(encrypted[index])
//         }
//     }
//     return decrypted;
// }

const key = 'token_key'
 
function aesEncrypt(data) {
    const cipher = crypto.createCipher('aes192', key)
    let crypted = cipher.update(data, 'utf8', 'hex')
    crypted += cipher.final('hex')
    return crypted
}
 
function aesDecrypt(encrypted) {
    const decipher = crypto.createDecipher('aes192', key)
    let decrypted = decipher.update(encrypted, 'hex', 'utf8')
    decrypted += decipher.final('utf8')
    return decrypted
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
        // if(!v) return
        // const data = JSON.parse(aesDecrypt(v))
        const data = JSON.parse(v)
        return data
    },
    setProductAllStorage(value) {
        const json = JSON.stringify(value)
        return sessionStorage.setItem(Product, json)
        // return sessionStorage.setItem(Product, aesEncrypt(json))
    },
    // 搜索的商店数据
    getShopAllStorage() {
        const v = sessionStorage.getItem(Shop_All)
        // if(!v) return
        // const data = JSON.parse(aesDecrypt(v))
        const data = JSON.parse(v)
        return data
    },
    setShopAllStorage(value) {
        const json = JSON.stringify(value)
        return sessionStorage.setItem(Shop_All, json)
        // return sessionStorage.setItem(Product, aesEncrypt(json))
    }
}