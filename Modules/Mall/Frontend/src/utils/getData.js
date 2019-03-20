
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
    // 3.获取用户信息
    async onGetUser() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/auth/get_user_info',
                method: 'post'
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }
            }).catch(err => {
                reject(err)
            })
        })
    },
    // 9.获取商品分类 2019-02-15修改路由
    async onGetAsideClass() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/shop/category/get_category',
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
    // 13.获取发件箱消息
    async onGetOutboxMessag() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/message/outbox_message',
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
    // 38.获取重置密码的member_id
    async onGetNumId(token) {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/auth/get_reset_password_member_id',
                params: {
                    "token": token
                }
            }).then(res => {
                resolve(res.data)
            }).catch(err => {
                reject(err)
            })
        })
    },
    // 42.获取单个商品的详情
    onGetProductInfo(id, user_id) {
        return new Promise((resolve, reject) => {
            request({
                url: '/shop/product/get_product_detail',
                params: {
                    "product_id": id,
                    "user_id": user_id
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
    // 49.获取店铺幻灯图片列表
    onGetSlidesList() {
        return new Promise((resolve, reject) => {
            request({
                url: '/shop/get_slides_list',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    },
    // 51.获取系统配置
    onGetSysConfig() {
        return new Promise((resolve, reject) => {
            request({
                url: "/get_sys_config"
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }
            }).catch(err => {
                return false;
            })
        })
    },
    // 52.获取商品推荐列表详情
    async onGetRecommendList() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/shop/get_recommend_product_list',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    },
    // 55.获取图片信息
    onGetImgInfo(path) {
        return new Promise((resolve, reject) => {
            request({
                url: '/album/get_img_info',
                params: {
                    image_path: path
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    },
    // 59.获取收藏
    async onGetFavorites() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/favorites/get_favorites',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    },
    // 61.获取分类商品的列表 //商城分类
    async onGetCategoryProduct(id) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/shop/category/get_category_product',
                method: 'get',
                params: {
                    categories_id: id
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    // this.$Message.error(res.message)
                    reject(res)
                }
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
    },
    // 66.获取用户头像
    async onGetAvatar() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/auth/get_avatar',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                    reject(res.data)
                }
            })
        })
    },
    // 68.获取账户信息
    async onGetAccountInfo() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/auth/get_account_info',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res.data)
                }
            })
        })
    },
    // 70.获取公司信息
    async onGetCompanyInfo() {
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/auth/get_company_info',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res.data)
                }
            })
        })
    },
    // 73.首页商品搜索
    onSearchProduct(params) {
        return new Promise((resolve, reject) => {
            request({
                url: '/shop/product/product_search',
                params: {
                    keywords: params
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    },
    // 74.首页店铺搜索
    onSearchShop(params) {
        return new Promise((resolve, reject) => {
            request({
                url: '/shop/shop_search',
                params: {
                    keywords: params
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    },
    // 75.获取公司信息详情（非登录状态也可用)
    onGetCompanyDetail(id, user_id) {
        return new Promise((resolve, reject) => {
            request({
                url: '/shop/get_company_detail',
                params: {
                    company_id  : id,
                    user_id: user_id
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    },
    // 76.获取商品分组下的商品 不登录也能用
    onGetProductList(id) {
        return new Promise((resolve, reject) => {
            request({
                url: '/shop/product_group/get_product_by_group_id',
                params: {
                    group_id  : id,
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    },

    // 78.获取用户中心商品分类数量与图片上传数量
    onGetProductNumInfo() {
        return new Promise((resolve, reject) => {
            request({
                url: '/shop/product/product_num_info',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    },

    // 81.广告获取接口
    onGetAdInfo() {
        return new Promise((resolve, reject) => {
            request({
                url: '/home/get_ad_info',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    },

    // 82.首页商品推荐获取
    onGetProductRecommend(user_id) {
        return new Promise((resolve, reject) => {
            request({
                url: '/home/get_index_product_recommend',
                params: {
                    "user_id": user_id //当登录时填 可以更加精准的获取个人推荐商品
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    },

    // 83.用户注册协议获取
    onGetUserAgreement(agreement_type) {
        return new Promise((resolve, reject) => {
            request({
                url: '/utils/get_user_agreement',
                params: {
                    "agreement_type": agreement_type     //必填 "merchants" 商家或者 "buyers" 买家
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    },

    // 84.获取系统公告列表
    onGetMallNotice(page, size) {
        return new Promise((resolve, reject) => {
            request({
                url: '/utils/get_mall_notice',
                params: {
                    "page": page,
                    "size": size
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    },

    // 85.文章详情获取
    onGetArticleDetail(article_id) {
        return new Promise((resolve, reject) => {
            request({
                url: '/utils/get_article_detail',
                params: {
                    article_id: article_id
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    },

    // 86.按照标题获取系统文章
    onGetTitleArticle(title) {
        return new Promise((resolve, reject) => {
            request({
                url: '/utils/get_title_article',
                params: {
                    title: title
                }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }
}

export default getData
