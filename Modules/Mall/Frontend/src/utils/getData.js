
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
    // 获取图片本地地址
    getObjectURL(file) {
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
    // 显示对应的数据
    filterAll(data, total) {
        return new Promise(resolve => {
            const { num, size } = total
            const dataFrom = data.slice(num * size - size, num * size)

            resolve(dataFrom)
        })
    },
    // 27.获取相册中的图片列表
    async onGetalbumPhotoList(params) {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/album/album_photo_list',
                params: params
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            }).catch(err => {
                reject(err)
            })
        })
    },
    // 29.获取相册id列表
    async onGetalbumIdList() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/album/album_list',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            }).catch(err => {
                reject(err)
            })
        })
    },
    // 30.获取商品分组列表
    async onGetProductGroup() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/shop/product_group/product_group_list',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            }).catch(err => {
                reject(err)
            })
        })
    },
    // 42.获取单个商品的详情
    async onGetProductInfo(id) {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/shop/product/get_product_detail',
                params: {
                    "product_id": id
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            }).catch(err => {
                reject(err)
            })
        })
    },
    // 47.获取店铺banner图片
    async onGetBanner() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/shop/get_shop_banner',
            }).then(res => {
                resolve(res)
            })
        })
    },
    // 62.获取商品列表
    async onGetReleaseProductList(data) {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/shop/product/get_product_list',
                params: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    },
    // 63.获取最近发布的商品分类
    async onGetLastProductsCategories() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/shop/category/get_last_products_categories',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    }

}

export default getData
