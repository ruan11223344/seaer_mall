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
    }
    
}

export default upData
