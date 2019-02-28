import request from './request'
import { resolve } from 'path';

const upData = {
    // 2.刷新token
    async upRegToken(data) {
        return await new Promise(async (resolve, reject) => {
            // 参数:"grant_type",值:"refresh_token"    //类型
            // 参数:"client_id",值:2              //客户端id（固定值)
            // 参数:"client_secret",值::"LfmILOffY40xTlFbJT2Q0V8gWyyu99cwlElNPKrK"  //客户端秘钥（固定值)
            // 参数:"refresh_token",值:"ruan4215@gmail.com"   //刷新tonken值 从获取token接口中获取
            await request({
                url: '/auth/get_access_token',
                method: 'post',
                data: {
                    grant_type: 'refresh_token',
                    client_id: 2,
                    client_secret: 'LfmILOffY40xTlFbJT2Q0V8gWyyu99cwlElNPKrK',
                    refresh_token: data
                },
            }).then(res => {
                resolve(res)
            }).catch(err => {
                reject(err)
            })
        })
    },
    // 22.上传图片到相册目录
    async upAlbumImg(file) {  // 
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/album/upload_img_to_album',
                method: 'post',
                data: file,
                headers:{'Content-Type':'multipart/form-data'}
            }).then(res => {
                resolve(res)
            }).catch(err => {
                reject(err)
            })
        })
    },
    // 23.保存上传的图片到相册
    async upSaveAlbumImg(data) {  // 
        return await new Promise(async (resolve, reject) => {
            await request({
                url: '/album/save_img_to_album',
                method: 'post',
                data: data,
            }).then(res => {
                resolve(res)
            }).catch(err => {
                reject(err)
            })
        })
    },
    // 38.发送重置密码邮件
    async onSendReset(data) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/auth/send_reset_password_email',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 39.提交重置密码 
    UpResetPass(data) {
        return new Promise((resolve, reject) => {
            request({
                url: '/auth/reset_password',
                method: 'post',
                data: data,
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 40.上传发布商品的图片
    UpProductImg(file, id) {
        const fromData = new FormData()

        fromData.append('product_img', file)
        fromData.append('where', id)

        return new Promise((resolve, reject) => {
            request({
                url: '/shop/product/upload_product_img',
                method: 'post',
                data: fromData,
                headers:{'Content-Type':'multipart/form-data'}
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 41.发布商品
    async upSaveproduct(data) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/shop/product/publish_product',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 43.删除商品
    async upDelProduct(data) {
        return new Promise((resolve, reject) => {
            request({
                url: '/shop/product/delete_product',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                    resolve(res.data)
                }else {
                    reject(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 44.编辑商品
    async upEditProduct(data) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/shop/product/edit_product',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                    resolve(res.data)
                }else {
                    this.$Message.info(res.message)
                    reject(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 45.上传幻灯图片
    async upSlides(base64) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/shop/upload_slide',
                method: 'post',
                data: {
                    slide_img_base64: base64
                }
            }).then(res => {
                resolve(res)
            }).catch(err => {
                return false
            })
        })
    },
    // 46.设置幻灯图片
    async upSetSlides(data) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/shop/set_slides',
                method: 'post',
                data: {
                    slides_list: data
                }
            }).then(res => {
                resolve(res)
            }).catch(err => {
                return false
            })
        })
    },
    // 48.设置店铺banner图片
    async onSetBanner(base64) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/shop/set_shop_banner',
                method: 'post',
                data: {
                    banner_img_base64: base64
                }
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                }else {
                    this.$Message.error(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 50.删除店铺banner图片
    async onDelBanner() {
        return await new Promise((resolve, reject) => {
            request({
                url: '/shop/delete_shop_banner',
                method: 'post',
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                }else {
                    this.$Message.error(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 53.设置商品推荐列表
    async onSetRecommendProductList(arr) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/shop/set_recommend_product_list',
                method: 'post',
                data: {
                    "product_id_list": arr
                }
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                }else {
                    this.$Message.error(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 54.替换相册图片接口
    async onReplaceAlbum(data) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/album/replace_img_to_album',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                }else {
                    this.$Message.error(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 57.添加收藏
    onSetFavorites(data) {
        return new Promise((resolve, reject) => {
            request({
                url: '/favorites/set_favorites',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 58.删除收藏
    async onDelFavorites(data) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/favorites/delete_favorites',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            }).catch(err => {
                return false
            })
        })
    },
    // 64.更改商品上架（放入审核中列表) 下架（放入仓库） 翻转接口
    async onChangeWarehouse(data) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/shop/product/change_products_warehouse',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    },
    // 65.更改用户密码
    async onChangePassword(data) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/auth/change_password',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    },
    // 67.设置用户头像
    async UpAvatarBase64(avatar_img_base64) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/auth/upload_avatar_img',
                method: 'post',
                data: {
                    avatar_img_base64: avatar_img_base64
                }
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    },
    // 69.设置账户信息
    async UpSetAccountInfo(data) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/auth/set_account_info',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    },
    // 71.上传营业执照
    async UpBusinessLicense(data) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/utils/upload_business_license',
                method: 'post',
                data: data,
                headers:{'Content-Type':'multipart/form-data'}
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    },
    // 72.设置公司信息
    async UpSetAccountInfo(data) {
        return await new Promise((resolve, reject) => {
            request({
                url: '/auth/set_company_info',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    this.$Message.info(res.message)
                    resolve(res.data)
                }else {
                    this.$Message.error(res.message)
                }
            })
        })
    },
}

export default upData
