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
    getSearchUserList() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/user_manager/get_user_list',
                params: {
                    "size":20,  //获取数量大小
                    "page":1,   //分页
                    "keywords":"ruan11223344" //关键词 member_id 或 email
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
    getMerchantList() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/user_manager/get_merchant_list',
                params: {
                    "size":20,  //获取数量大小
                    "page":1,   //分页
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