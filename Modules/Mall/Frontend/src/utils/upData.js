import request from './request'
import { resolve } from 'path';

const upData = {
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
                    resolve(res.data)
                }else {
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
    // 64.更改商品上架（放入审核中列表) 下架（放入仓库） 翻转接口
    async onChangeWarehouse() {
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
    }
}

export default upData
