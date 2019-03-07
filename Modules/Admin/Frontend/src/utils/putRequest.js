import request from "./request"

class putRequest {
    // 2.获取access_token
    putToken() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/auth/get_access_token',
                method: 'post',
                data: {
                    "grant_type":"password",   //必填  固定值
                    "client_id":"2",    //必填  固定值
                    "client_secret":"LfmILOffY40xTlFbJT2Q0V8gWyyu99cwlElNPKrK",   //必填  固定值
                    "username":"admind", //必填  用户名 或者 邮箱
                    "password":"123456", //必填  密码 
                    "captcha":"2u687",    //必填  验证码
                    "key":"$2y$10$qYJzuz7BppnkJL9KmAYdCeH/stpP0F6znSZAWUom9n5I.h7HM7VCO",  //必填   验证码key
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
    putInquiryJurisdiction() {
        return new Promise(async (resolve, reject) => {
            await request({
                url: '/admin/user_manager/set_inquiry',
                method: 'post',
                data: {
                    "user_id": 1
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

export default new putRequest()