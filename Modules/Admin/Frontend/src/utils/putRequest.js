import request from "./request"

class PutRequest {
    // 2.获取access_token
    putToken(key, obj) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/auth/get_access_token',
                method: 'post',
                data: {
                    "grant_type":"password",   //必填  固定值
                    "client_id":"2",    //必填  固定值
                    "client_secret":"LfmILOffY40xTlFbJT2Q0V8gWyyu99cwlElNPKrK",   //必填  固定值
                    "username": obj.username, //必填  用户名 或者 邮箱
                    "password": obj.password, //必填  密码 
                    "captcha": obj.code,    //必填  验证码
                    "key": key,  //必填   验证码key
                    "provider":"admins"  //必填  固定值
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

    // 5.设置用户是否能够使用询盘 （翻转接口)
    putInquiryJurisdiction(id) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/user_manager/set_inquiry',
                method: 'post',
                data: {
                    "user_id": id
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

    // 7.创建管理员
    putAddAdmin(data) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/auth/add_admin',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 9.添加角色(权限组)
    putAddRole(data) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/role_manager/add_role',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 9.修改角色(权限组)
    putEditRole(data) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/role_manager/edit_role',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 14.编辑管理员信息
    putEditAdmin(data) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/user_manager/edit_admin',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 19.审核商品
    putProductAudit(data) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/product_manager/product_audit',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 20.下架商品
    putProductShelf(data) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/product_manager/product_off_shelf',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 21.发布文章
    putProductArticle(data) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/article_manager/publish_article',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 23.编辑文章
    putProductEditArticle(data) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/article_manager/edit_article',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 24.删除文章
    putDelArticle(article_id) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/article_manager/delete_article',
                method: 'post',
                data: {
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
    }

    // 31.管理员处理反馈
    putProcess(data) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/feedback_manager/process_feedback',
                method: 'post',
                data: data
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 32.通用上传图片接口
    putUploadImg(file) {
        const fromData = new FormData()

        fromData.append('img', file)

        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/utils/upload_img',
                method: 'post',
                data: fromData,
                headers: { 'Content-Type':'multipart/form-data' }
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 34.登出接口
    putLogout() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/auth/logout',
                method: 'post',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 35.刷新token
    putRefToken(Token) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/auth/get_access_token',
                method: 'post',
                data: {
                    "grant_type": "refresh_token", //类型
                    "client_id": 2, //客户端id（固定值)
                    "client_secret": "LfmILOffY40xTlFbJT2Q0V8gWyyu99cwlElNPKrK", //客户端秘钥（固定值)
                    "refresh_token": Token, //刷新tonken值 从获取token接口中获取
                    "provider": "admins" //必填 固定值
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

export default new PutRequest()