import request from "./request"

class getRequest {
    // 1.获取验证码
    getCode() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/utils/get_captcha'
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 3.获取用户列表
    getUserList(size, page) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/user_manager/get_user_list',
                params: {
                    "size": size,  //获取数量大小
                    "page": page   //分页
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

    // 4.搜索用户列表
    getSearchUserList(size, page, key) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/user_manager/get_user_list',
                params: {
                    "size": size,  //获取数量大小
                    "page": page,   //分页
                    "keywords": key //关键词 member_id 或 email
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

    // 6.获取商家列表
    getMerchantList(size, page) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/user_manager/get_merchant_list',
                params: {
                    "size": size,  //获取数量大小
                    "page": page,   //分页
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

    // 8.获取权限组列表
    getJurisdictionList() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/role_manager/get_role_list',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 12.获取管理员列表
    getAdminList(size, page) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/user_manager/get_admin_list',
                params: {
                    "size": size,  //获取数量大小
                    "page": page,   //分页
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

    // 16.全部商品列表获取
    getProductList(size, page) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/product_manager/get_product_list',
                params: {
                    "size": size,  //获取数量大小
                    "page": page,   //分页
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

    // 17.待审核商品列表获取
    getProductAuditList(size, page) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/product_manager/get_product_audit_list',
                params: {
                    "size": size,  //获取数量大小
                    "page": page,   //分页
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

    // 18.商品审核点击商品详情获取
    getProductInfo(product_id) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/product_manager/get_product_info',
                params: {
                    "product_id": product_id
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

    // 22.获取文章详情
    getArticleDetail(article_id) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/article_manager/get_article_detail',
                params: {
                    "article_id": article_id  //文章id 必填
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

    // 25.获取用户协议列表
    getAgreementsList(size, page) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/article_manager/get_agreements_list',
                params: {
                    "page": page,  //必填 页码
                    "size": size  //必填 数量
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

    // 26.获取系统文章列表
    getArticleList(size, page) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/article_manager/get_system_article_list',
                params: {
                    "page": page,  //必填 页码
                    "size": size  //必填 数量
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

export default new getRequest()