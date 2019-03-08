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
}

export default new PutRequest()