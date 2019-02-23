
// class getData {
//     async getProvinceAddress(code) { // 获取省份地址
//         console.log(1111)
//         return await new Promise(async (resolve, reject) => {
//             await this.$request({
//                 url: '/utils/get_provinces_list',
//                 params: {
//                     country_code: code // 国家代码
//                 }
//             }).then(res => {
//                 console.log(res)
//                 resolve(res)
//             }).catch(err => {
//                 reject(err)
//             })
//         })
//     }

//     async getCityAddress() { // 获取城市地址

//     }
// }

// export default getData
import request from './request'

const getData = {
   async getCode() {  // 获取验证码
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/utils/get_captcha'
            }).then( (res) => {
                resolve(res)
            }).catch(err => {
                reject(err)
            })
        })
    },

    async getCityAddress(code) { // 城市地址
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/utils/get_city_list',
                params: {
                    province_id: code // 国家代码
                }
            }).then(res => {
                resolve(res)
            }).catch(err => {
                reject(err)
            })
        })
    },

    async getProvinceAddress(code) { // 省份地址
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/utils/get_provinces_list',
                params: {
                    country_code: code // 国家代码
                }
            }).then(res => {
                resolve(res)
            }).catch(err => {
                reject(err)
            })
        })
    },

    getObjectURL(file) {  // 获取图片本地地址
        let url = null;  
        if (window.createObjcectURL != undefined) {  
        url = window.createOjcectURL(file);  
        } else if (window.URL != undefined) {  
        url = window.URL.createObjectURL(file);  
        } else if (window.webkitURL != undefined) {  
        url = window.webkitURL.createObjectURL(file);  
        }  
        return url;
    },

    // 29.获取相册id列表
    async onGetalbumIdList() {  // 
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/album/album_list',
            }).then(res => {
                resolve(res)
            }).catch(err => {
                reject(err)
            })
        })
    },
}

export default getData
