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

    // 11.获取角色已有权限列表(权限组)
    getRolePermissions(role_id) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/role_manager/get_role_permissions',
                params: {
                    role_id: role_id
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

    // 27.获取系统公告列表
    getSystemList(size, page) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/article_manager/get_system_announcement_list',
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

    // 28.获取广告管理列表
    getAdList() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/ad_manager/get_ad_list'
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 30.获取反馈列表
    getFeedbackList(size, page) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/feedback_manager/get_feedback_list',
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

    // 33.首页统计与图表数据
    getHomeData() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/utils/get_index_data',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 36.获取首页推荐商品列表
    getProductRecommend() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/ad_manager/get_index_product_recommend',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 38.获取正在销售的商品列表
    getSaleProduct(size, page) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/ad_manager/get_sale_product',
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

    // 39.搜索正在销售的商品列表
    getSearchProduct(size, page, keywords, name) {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/ad_manager/get_sale_product_search',
                params: {
                    "page": page,  //必填 页码
                    "size": size,  //必填 数量
                    "keywords": keywords,
                    "status": name
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

    // 40.获取所有权限列表
    getPermissionsList() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/role_manager/get_permissions_list',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 40.获取可访问的路由
    getAccessRoute() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/auth/can_access_route',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 41.获取账户信息
    getAccountInfo() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/auth/get_account_info',
            }).then(res => {
                if(res.code == 200) {
                    resolve(res.data)
                }else {
                    reject(res)
                }
            })
        })
    }

    // 43.获取管理员最近上传的照片历史
    getLastUploadImg() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/utils/get_last_upload_img',
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