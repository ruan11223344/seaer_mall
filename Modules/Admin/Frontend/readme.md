## 接口说明 域名 admin.seaer.local

1.获取验证码
```
url:http://域名/api/admin/utils/get_captcha
请求方法:get
参数:"无"  
  
返回:
{
    "code": 200,
    "message": "获取验证码成功!",
    "data": {
        "sensitive": false,
        "key": "$2y$10$WnxYbkMWgq1ma/Rf0VGow.4IUDVWhTJyG0aKSlSl2gJyc3ATp8yTm",
        "img": "data:image/png;base64,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"
    }
}
```

2.获取access_token
```
url:http://域名/api/admin/auth/get_access_token
请求方法:post
json参数:
{
"grant_type":"password",   //必填  固定值
"client_id":"2",    //必填  固定值
"client_secret":"LfmILOffY40xTlFbJT2Q0V8gWyyu99cwlElNPKrK",   //必填  固定值
"username":"admind", //必填  用户名 或者 邮箱
"password":"123456", //必填  密码 
"captcha":"2u687",    //必填  验证码
"key":"$2y$10$qYJzuz7BppnkJL9KmAYdCeH/stpP0F6znSZAWUom9n5I.h7HM7VCO",  //必填   验证码key
"provider":"admins"  //必填  固定值
}
返回:
{
    "code": 200,
    "message": "Success!",
    "data": {
        "token_type": "Bearer",
        "expires_in": 1296000,
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQwNTg3Y2QxYmU4NjU3OThiNGRhY2UyMjE4Yjk1MTdhZmQ2OTBkNjA1YjJiNTVjMjRjYjk0N2UzMzA1NTA3ZGRiOGNhZTliZGIyODE1ZjBhIn0.eyJhdWQiOiIyIiwianRpIjoiZDA1ODdjZDFiZTg2NTc5OGI0ZGFjZTIyMThiOTUxN2FmZDY5MGQ2MDViMmI1NWMyNGNiOTQ3ZTMzMDU1MDdkZGI4Y2FlOWJkYjI4MTVmMGEiLCJpYXQiOjE1NTE3NjQ5MTQsIm5iZiI6MTU1MTc2NDkxNCwiZXhwIjoxNTUzMDYwOTE0LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.bwiMNYgkFfge3K1m3hPRSDEwGV-HO56E0vOdp-VyiQEaQPyXlbozuZU3H3jWMytAqDNKQu82yH51kpddm4vbhgva08PiXC6UBY4VQWDvnLGRnWPVrlIeqqZT12P4vifJLCVHIvzT7l9YFLPBtGJmGQYaFAw-I7OtuiZ7-TgOnh7BkNf1VuvABQXUkUIR5UMB0ltF-LE4P1ROPGlBJXZateGcx4jWnFM_55nO2gyspdj4mC16ZvOpisXkIwZbX1hj042LzwZvar4oZO1Z0hLCsK59kA7523RfSyQZE8rjmKPE00UfuvUqsBzGHL4kT5NbhsW9Ewesu43zdLebXxEFfGU7y5zPHsYMBB2ieODqhhESAu1cDqmzOwgpVhkqxkr1y7jzbnH4ANGvhJ2_RvXE9u5NmLsYncf6PnmETQArbevO1IeCWxRL6lqFYxAbzJsO9S3AOA7Tgnw_h4752n3N4xHt0cEIRmF4teztzWoZxZ2AueOHxaBgFCahr1oCyMFr8W9YL2AipaAG4GCmdY0qTTdC9wlTljziJpvwFCZYwn0OYYXIDbUCfJwZfuJH8qFKtg8yg_Xn332ChQdvYUQjPTqNH4bt9rWoqAENIXcUteFnhsfpxbV98G8Vnf52nKTL80iZq2dJv100ZhKcdc5zMkEvVx8CfptRIzr5beiPl1o",
        "refresh_token": "def502007e4fc7a2cbdf66972d4ebbfec24ac9c2128266b06ac85a3caa52ed24ad207c67c0636d5a547ec0c5ac8d1ddfcda0acf7c7d08b0f8acfc8c1ce5a0ca1e3105858c23423abdfe47cb752d61c32a7b7071377abdc874c2f1d58ebcc572a21aec87310d1a616daf93f7294d34fdbff1b87cf4e4d683124d7cc56e7ae169504527cd281314252f5d4a9bf74dfd672373138caf5653d22797e56ce2d6c1d40af2916b2e979e86dccc786adbe599b6bf08520178bc8f1c75a908d2797f12faa37469d89bc8d1e7b1f183080c99ea92940bc73673121f81a81377d90e859a804581841556b2c08f4fcef0f8a1f895a52092b646e7c178e2120bcff41c244ed174da1c80a87486a120af03cd40d1b201da8885764ea2a8656ef21ad31fadfb84da769fb22067f7af0c7e81e12265306281d830d2761e304e424458497048bb6b0c7db1199a8d06ea6a527c1276d5c8e2e31f9738d7133c0f9520e1be9ae4a938731"
    }
}
```
  
3.获取用户列表
```
url:http://域名/api/admin/user_manager/get_user_list
请求方法:get
json参数:
{
	"size":20,  //获取数量大小
	"page":1   //分页
}
返回:
{
    "code": 200,
    "message": "成功!",
    "data": {
        "data": [
            {
                "num": 1,
                "register_time": "2019-01-07",
                "af_id": "AF_CN_c1dce03043",
                "member_id": "admin",
                "email": "ruan4215@gmail.com",
                "contact_full_name": "王尼玛",
                "sex": "Mrs",
                "phone_num": "+8613672009476",
                "address": "湖北省黄石市西塞山去王子大战飞机温度计的时间23后 手动",
                "last_login": "2019-03-08"
            },
            {
                "num": 2,
                "register_time": "2019-01-18",
                "af_id": "AF_CN_c1dce03047",
                "member_id": "ruan11223344",
                "email": "13672009476@qq.com",
                "contact_full_name": "wang ni ma",
                "sex": "Mr",
                "phone_num": null,
                "address": null,
                "last_login": ""
            },
            {
                "num": 3,
                "register_time": "2019-01-18",
                "af_id": "AF_KE_c1dce03057",
                "member_id": "test444",
                "email": "test1@qq.com",
                "contact_full_name": "wang ni massssss",
                "sex": "Mr",
                "phone_num": null,
                "address": null,
                "last_login": ""
            },
            {
                "num": 4,
                "register_time": "2019-01-08",
                "af_id": "AF_CN_7a49b34079",
                "member_id": "tests",
                "email": "421566927@qq.com",
                "contact_full_name": "王飞飞",
                "sex": "Miss",
                "phone_num": "+8613672009476",
                "address": "湖北省黄石市西塞山去王子大战飞机温度计的时间23后 手动",
                "last_login": ""
            },
            {
                "num": 5,
                "register_time": "2019-03-06",
                "af_id": "AF_KE_febbd7b082",
                "member_id": "testssssgr",
                "email": "goj8@foxmail.com",
                "contact_full_name": "wang ni massssss",
                "sex": "Mr",
                "phone_num": null,
                "address": null,
                "last_login": ""
            },
            {
                "num": 6,
                "register_time": "2019-03-06",
                "af_id": "AF_KE_219b46908d3",
                "member_id": "testssssgrssss",
                "email": "diy8867@qq.com",
                "contact_full_name": "wang ni massssss",
                "sex": "Mr",
                "phone_num": null,
                "address": null,
                "last_login": ""
            },
            {
                "num": 7,
                "register_time": "2019-03-06",
                "af_id": "AF_KE_219b469083",
                "member_id": "testssssgrs",
                "email": "diy886@qq.com",
                "contact_full_name": "wang ni massssss",
                "sex": "Mr",
                "phone_num": null,
                "address": null,
                "last_login": ""
            }
        ],
        "size": 20,
        "cur_page": 1,
        "total_page": 1,
        "total_size": 7
    }
}
```

4.搜索用户列表
```
url:http://域名/api/admin/user_manager/get_user_list
请求方法:get
json参数:
{
	"size":20,  //获取数量大小
	"page":1,   //分页
	"keywords":"ruan11223344" //关键词 member_id 或 email
}
返回:
{
    "code": 200,
    "message": "成功!",
    "data": {
        "data": [
            {
                "num": 1,
                "register_time": "2019-01-18",
                "af_id": "AF_CN_c1dce03047",
                "member_id": "ruan11223344",
                "email": "13672009476@qq.com",
                "contact_full_name": "wang ni ma",
                "sex": "Mr",
                "phone_num": null,
                "address": null,
                "last_login": ""
            }
        ],
        "size": 20,
        "cur_page": 1,
        "total_page": 1,
        "total_size": 1
    }
}
```

5.设置用户是否能够使用询盘 （翻转接口)
```
url:http://域名/api/admin/user_manager/set_inquiry
请求方法:post
json参数:
{
	"user_id":1
}

返回:
{
    "code": 200,
    "message": "设置用户询盘成功!",
    "data": {
        "user_id": 1,
        "allow_inquiry": true
    }
}
```

6.获取商家列表
```
url:http://域名/api/admin/user_manager/get_merchant_list
请求方法:get
json参数:
{
	"size":20,  //获取数量大小
	"page":1,   //分页
}

返回:

{
    "code": 200,
    "message": "成功!",
    "data": {
        "data": [
            {
                "num": 1,
                "user_id": 1,
                "open_shop_time": "2019-03-05",
                "company_name": "sb company",
                "contact_full_name": "王尼玛",
                "sex": "Mrs",
                "phone_num": "+8613672009476",
                "email": "ruan4215@gmail.com",
                "address": "湖xx北省黄石市西塞山去王子大战飞机温度计的时间23后 手动",
                "product_num": 1,
                "last_login": "2019-03-08",
                "allow_inquiry": true
            },
            {
                "num": 2,
                "user_id": 7,
                "open_shop_time": "",
                "company_name": "test company",
                "contact_full_name": "wang ni ma",
                "sex": "Mr",
                "phone_num": null,
                "email": "13672009476@qq.com",
                "address": null,
                "product_num": 0,
                "last_login": "",
                "allow_inquiry": true
            },
            {
                "num": 3,
                "user_id": 10,
                "open_shop_time": "",
                "company_name": "Ningbo Associated Hydraulic Components Co.,LTD.",
                "contact_full_name": "wang ni massssss",
                "sex": "Mr",
                "phone_num": null,
                "email": "test1@qq.com",
                "address": null,
                "product_num": 0,
                "last_login": "",
                "allow_inquiry": true
            },
            {
                "num": 4,
                "user_id": 13,
                "open_shop_time": "",
                "company_name": "wangzi  compangys",
                "contact_full_name": "王飞飞",
                "sex": "Miss",
                "phone_num": "+8613672009476",
                "email": "421566927@qq.com",
                "address": "湖北省xx黄石市西塞山去王子大战飞机温度计的时间23后 手动",
                "product_num": 15,
                "last_login": "",
                "allow_inquiry": false
            }
        ],
        "size": 20,
        "cur_page": 1,
        "total_page": 1,
        "total_size": 4
    }
}
```

7.创建管理员
```
url:http://域名/api/admin/auth/add_admin
请求方法:post
json参数:
{
	"admin_name":"张文俊1", //管理员名
	"password":"123456",   //密码 
	"password_confirmation":"123456",  //重复密码
	"role_id":1  //权限组id
}

返回:

{
    "code": 200,
    "message": "创建管理员成功!",
    "data": []
}
```

8.获取权限组列表
```
url:http://域名/api/admin/role_manager/get_role_list
请求方法:get
json参数:
{
	"admin_name":"张文俊1", //管理员名
	"password":"123456",   //密码 
	"password_confirmation":"123456",  //重复密码
	"role_id":1  //权限组id
}

返回:

{
    "code": 200,
    "message": "获取角色列表成功!",
    "data": [
        {
            "role_id": 1,
            "role_name": "一级管理员",
            "role_display_name": "一级管理员",
            "description": null
        }
    ]
}
```

9.添加角色(权限组)
```
url:http://域名/api/admin/role_manager/add_role
请求方法:post
json参数:
{
	"role_name":"三级管理员",  //角色名
	"all_permissions":false,  //注意 是否给予所有权限 如果是true  那么参数permissions_list 请传空数组 []
	"permissions_list":[1]   //权限列表
}

返回:
{
    "code": 200,
    "message": "创建权限组成功!",
    "data": {
        "role_name": "三级管理员",
        "role_id": 4
    }
}
```

9.修改角色(权限组)
```
url:http://域名/api/admin/role_manager/edit_role
请求方法:post
json参数:
{
	"role_name":"test管理员",  //要修改的角色名
	"role_id":"3",            //角色id
	"all_permissions":false,  //是否给予所有权限 注意 如果是true 那么参数permissions_list 请传空数组 []
	"permissions_list":[1,2]  //权限id列表  数组
}

返回:
{
    "code": 200,
    "message": "修改权限组成功!",
    "data": [
        {
            "permission_id": 1,
            "permission_name": "admin.user.admin.list",
            "display_name": "获取管理员列表",
            "description": "获取管理员列表详情"
        },
        {
            "permission_id": 2,
            "permission_name": "admin.user.admin.test",
            "display_name": "ffff",
            "description": "ssdssd"
        }
    ]
}
```

10.删除角色(权限组) 
```
url:http://域名/api/admin/role_manager/delete_role
请求方法:post
json参数:
{
	"role_id":3  //角色id
}

返回:
{
    "code": 200,
    "message": "删除权限组成功!",
    "data": []
}
```

11.获取角色已有权限列表(权限组) 
```
url:http://域名/api/admin/role_manager/get_role_permissions
请求方法:get
json参数:
{
	"role_id":7  //角色id
}
返回:
{
    "code": 200,
    "message": "获取角色权限列表成功!",
    "data": [
        {
            "permission_id": 1,
            "permission_name": "admin.user.admin.list",
            "display_name": "获取管理员列表",
            "description": "获取管理员列表详情"
        },
        {
            "permission_id": 2,
            "permission_name": "admin.user.admin.test",
            "display_name": "ffff",
            "description": "ssdssd"
        },
        {
            "permission_id": 3,
            "permission_name": "admin.user.setInquiry",
            "display_name": "设置询盘",
            "description": "设置用户是否能够发送询盘"
        },
        {
            "permission_id": 4,
            "permission_name": "admin.user.merchants.list",
            "display_name": "获取商家列表",
            "description": "管理员是否能够获取商家列表"
        },
        {
            "permission_id": 5,
            "permission_name": "admin.user.list",
            "display_name": "访问用户列表",
            "description": "访问afriby非商家的用户列表"
        },
        {
            "permission_id": 6,
            "permission_name": "admin.user.search",
            "display_name": "搜索用户列表",
            "description": "搜索afriby非商家的用户列表"
        }
    ]
}
```

12.获取管理员列表
```
url:http://域名/api/admin/user_manager/get_admin_list
请求方法:get
json参数:
{
	"size":20,
	"page":1
}

返回:
{
    "data": [
        {
            "num": 1,
            "admin_name": "admin",
            "last_login": "2019-03-08",
            "login_count": 1,
            "role_name": "五级管理员"
        },
        {
            "num": 2,
            "admin_name": "admind",
            "last_login": "2019-03-09",
            "login_count": 2,
            "role_name": ""
        },
        {
            "num": 3,
            "admin_name": "张文俊",
            "last_login": "",
            "login_count": 0,
            "role_name": ""
        },
        {
            "num": 4,
            "admin_name": "张文俊1",
            "last_login": "",
            "login_count": 0,
            "role_name": ""
        }
    ],
    "size": 20,
    "cur_page": 1,
    "total_page": 1,
    "total_size": 4
}
```

13.获取管理员详细信息
```
url:http://域名/api/admin/user_manager/get_admin_info
请求方法:get
json参数:
{
	"admin_id":1
}

返回:
{
    "code": 200,
    "message": "获取管理员信息成功!",
    "data": {
        "admin_name": "admin",
        "role_name": "五级管理员",
        "role_id": 7
    }
}
```

14.编辑管理员信息
```
url:http://域名/api/admin/user_manager/edit_admin
请求方法:post
json参数:
{
	"admin_id":1,  //必填 管理员id
	"admin_name":"admin", //要更改成管理员登录名 如果不改 传null 或者不传键
	"password":123456,  //要更改成管理员密码 如果不改 传null 或者不传键
	"role_id":6 //必填 要改成哪个权限组的id 
}

返回:
{
    "code": 200,
    "message": "编辑管理员成功!",
    "data": {
        "admin_name": "admin",
        "role_name": "四级管理员",
        "role_id": 6
    }
}
```

15.删除管理员
```
url:http://域名/api/admin/user_manager/delete_admin
请求方法:post
json参数:
{
	"admin_id":6
}

返回:
{
    "code": 200,
    "message": "删除管理员成功!",
    "data": []
}
```

16.全部商品列表获取
```
url:http://域名/api/admin/product_manager/get_product_list
请求方法:get
json参数:
{
	"page":1,
	"size":3
}

返回:
{
    "code": 200,
    "message": "获取商品列表数据成功!",
    "data": {
        "data": [
            {
                "num": 1,
                "product_id": 33,
                "product_origin_id": "PD_CN_a49b34079_8f538e50",
                "product_price": "10-8",
                "company_name": "wangzi  compangys",
                "company_detail_address": "湖北省xxsdsadjkdsajkdsajdkjsakdj111111",
                "product_status": 1,
                "product_audit_status": 0,
                "product_status_str": "等待审核"
            },
            {
                "num": 2,
                "product_id": 34,
                "product_origin_id": "PD_CN_a49b34079_eaf2d120",
                "product_price": "100-2010",
                "company_name": "wangzi  compangys",
                "company_detail_address": "湖北省xxsdsadjkdsajkdsajdkjsakdj111111",
                "product_status": 1,
                "product_audit_status": 2,
                "product_status_str": "未通过审核"
            },
            {
                "num": 3,
                "product_id": 35,
                "product_origin_id": "PD_CN_a49b34079_eaf2d120",
                "product_price": "100-2010",
                "company_name": "wangzi  compangys",
                "company_detail_address": "湖北省xxsdsadjkdsajkdsajdkjsakdj111111",
                "product_status": 1,
                "product_audit_status": 1,
                "product_status_str": "出售中"
            }
        ],
        "size": 3,
        "cur_page": 1,
        "total_page": 9,
        "total_size": 25
    }
}
```

17.待审核商品列表获取
```
url:http://域名/api/admin/product_manager/get_product_audit_list
请求方法:get
json参数:
{
	"page":1,
	"size":3
}

返回:
{
    "code": 200,
    "message": "获取待审核商品列表数据成功!",
    "data": {
        "data": [
            {
                "num": 1,
                "product_id": 33,
                "product_origin_id": "PD_CN_a49b34079_8f538e50",
                "product_price": "10-8",
                "company_name": "wangzi  compangys",
                "company_detail_address": "湖北省xxsdsadjkdsajkdsajdkjsakdj111111",
                "product_status": 1,
                "product_audit_status": 0,
                "product_status_str": "等待审核"
            }
        ],
        "size": 3,
        "cur_page": 1,
        "total_page": 1,
        "total_size": 1
    }
}
```

18.商品审核点击商品详情获取
```
url:http://域名/api/admin//product_manager/get_product_info
请求方法:get
json参数:
{
	"product_id":33  //商品id
}

返回:
{
    "code": 200,
    "message": "成功!",
    "data": {
        "company_info": {
            "company_business_type_id": "2",
            "company_business_type_str": "贸易公司",
            "company_name": "wangzi  compangys",
            "company_name_in_china": "王子有限公司",
            "company_country": "China",
            "province/city": "Nyanza Sumale",
            "company_detailed_address": "湖北省xxsdsadjkdsajkdsajdkjsakdj111111",
            "company_mobile_phone": "+8617671770827",
            "company_website": "http://www.qq.com/",
            "company_business_range_ids": "10,11,12,13",
            "company_business_range_ids_str": " Electrical & Electronics、 Furniture、 Health & Medicine、 Industrial Equipment & Components",
            "company_main_products": "飞机,毛线,军舰",
            "company_main_products_str": "飞机、毛线、军舰",
            "company_profile": "我们公司打手电阿萨德阿萨德奥术大师多阿萨德撒的撒的撒大声地打的阿萨德阿萨德撒的阿萨德 阿斯顿撒多撒打算打打",
            "company_business_license": "421002600458688",
            "company_business_license_pic_url": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_7a49b34079/private/155117078539651851.jpeg"
        },
        "product_info": {
            "product_categories_id": "31",
            "product_categories_str": "Auto & Transportation > Transmission Parts > Intermediate Gear",
            "product_name": "超级无敌玩毛车玩具13fffxxx333",
            "product_sku_no": "100025",
            "product_keywords": [
                "玩具",
                "赛车"
            ],
            "product_keywords_str": "玩具-赛车",
            "product_images_url": [
                "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_7a49b34079/product/155047099099801852.jpeg",
                "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/http://www.xx.com/2.jpg",
                "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/http://www.xx.com/2.jpg",
                "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/http://www.xx.com/2.jpg",
                "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/http://www.xx.com/2.jpg"
            ],
            "product_attr_arr": [
                "颜色",
                "颜rrr色",
                "容f量",
                "容g量",
                "尺v寸",
                "尺s寸"
            ],
            "product_attr_str": "颜色、颜rrr色、容f量、容g量、尺v寸、尺s寸",
            "product_price_type": "ladder",
            "product_price_str_arr": [
                {
                    "moq": "MOQ: 10-20 Pieces",
                    "unit": "Pieces",
                    "price": "10"
                },
                {
                    "moq": "MOQ: 21-30 Pieces",
                    "unit": "Pieces",
                    "price": "9"
                },
                {
                    "moq": "MOQ: ≥31",
                    "unit": "Pieces",
                    "price": "8"
                }
            ]
        },
        "product_publish_time": ""
    }
}
```

19.审核商品
```
url:http://域名/api/admin/product_manager/product_audit
请求方法:post
json参数:
{
	{
    "product_id":33,    //商品id
    "action":"reject",      // reject 或 allow 两个值
    "reject_message":"包含裸露图片信息。"  //action为allow时不填或者不传
    }
}

返回:
{
    "code": 200,
    "message": "操作成功!",
    "data": []
}
```

20.下架商品
```
url:http://域名/api/admin/product_manager/product_off_shelf
请求方法:post
json参数:
{
	"product_id":33,  //商品id
	"off_shelf_message":"你已经违规了!"  //消息
}

返回:
{
    "code": 200,
    "message": "操作成功!",
    "data": []
}
```

21.发布文章
```
url:http://域名/api/admin/article_manager/publish_article
请求方法:post
json参数:
{
	"type":"user_agreements",  //文章类型   四个值可选 buyers_register_agreement,merchants_register_agreement,system_announcement,system_article   
	"content":"用户协议内容",  必填!
	"title":"我是大帅哥"  标题 非必填！
}

返回:
{
    "code": 200,
    "message": "发布成功!",
    "data": {
        "type": "user_agreements",
        "content": "用户协议内容",
        "title": "我是大帅哥",
        "admin_id": 10,
        "updated_at": "2019-03-14 09:42:28",
        "created_at": "2019-03-14 09:42:28",
        "id": 2
    }
}
```

22.获取文章详情
```
url:http://域名/api/admin/article_manager/get_article_detail
请求方法:post
json参数:
{
	"article_id":"1"  //文章id 必填
}

返回:
{
    "code": 200,
    "message": "成功!",
    "data": {
        "id": 1,
        "admin_id": 10,
        "author": null,
        "title": "我是大帅哥",
        "content": "是的撒大\n\r\n<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Iconfont-阿里巴巴矢量图标库</title>\n  <meta name=\"description\" content=\"Iconfont-国内功能很强大且图标内容很丰富的矢量图标库，提供矢量图标下载、在线存储、格式转换等功能。阿里巴巴体验团队倾力打造，设计和前端开发的便捷工具\" />\n  <meta name=\"keywords\" content=\"中国 矢量图标库 下载 在线存储 格式转换 阿里巴巴体验团队 Iconfont\" />\n  <meta name=\"google\" value=\"notranslate\">\n  <meta name=\"baidu-site-verification\" content=\"0fFS5DZPGS\" />\n\n  <script>\n    (function(){\n      var domain = location.href\n      var reg = /^http:\\/\\/(www\\.)?iconfont\\.cn/\n      if (location.protocol === 'http:' && reg.test(domain)) {\n        location.href = domain.replace(reg, 'https://www.iconfont.cn')\n      }\n    })()\n    \n  </script>\n\n  <link rel=\"shortcut icon\" href=\"//gtms04.alicdn.com/tps/i4/TB1_oz6GVXXXXaFXpXXJDFnIXXX-64-64.ico\" type=\"image/x-icon\"/>\n  <link rel=\"stylesheet\" type=\"text/css\" href=\"//g.alicdn.com/thx/cube/1.3.1/neat.min.css\">\n  <link rel=\"stylesheet\" type=\"text/css\" href=\"//g.alicdn.com/mm/iconfont-plus-bp/2.2.12/app/assets/index.css\">\n  <script type=\"text/javascript\" src=\"//g.alicdn.com/mm/iconfont-plus-bp/2.2.12/app/libs/sea.js\"></script>\n  <meta content=\"\" name=\"csrf-ctoken\" />\n  <meta content=\"cK9mFMAc-77AebvcaSt3F-2PIaqkLM-KYFXQ\" name=\"csrf-token\" />\n  <meta name=\"data-spm\" content=\"a313x\">\n</head>\n\n<body data-spm=\"7781069\">\n  <div id=\"root\"></div>\n  <script type=\"text/javascript\" id=\"beacon-aplus\" src=\"//g.alicdn.com/alilog/mlog/aplus_o.js\"  exparams=\"clog=o&aplus&sidx=aplusSidx&ckx=aplusCkx\"></script>\n\n  <script type=\"text/javascript\" src=\"//g.alicdn.com/mm/iconfont-plus-bp/2.2.12/app/boot.js\"></script>\n\n  <script type=\"text/javascript\">var cnzz_protocol = \" https://\";document.write(unescape(\"%3Cspan id='cnzz_stat_icon_1260547936'%3E%3C/span%3E%3Cscript src='\" + cnzz_protocol + \"s11.cnzz.com/z_stat.php%3Fid%3D1260547936' type='text/javascript'%3E%3C/script%3E\"));</script>\n\n</body>\n</html>",
        "type": "user_agreements",
        "deleted_at": null,
        "created_at": "2019-03-14 09:34:05",
        "updated_at": "2019-03-14 09:34:05"
    }
}
```


23.编辑文章
```
url:http://域名/api/admin/article_manager/edit_article
请求方法:post
json参数:
{
	"article_id":"1",  //文章id 
	"content":"2323232",  //内容 非必填
	"title":"我是传奇!"  //标题 非必填
}

返回:
{
    "code": 200,
    "message": "编辑成功!",
    "data": {
        "id": 1,
        "admin_id": 10,
        "author": null,
        "title": "等等撒的",
        "content": "23232324",
        "type": "user_agreements",
        "deleted_at": null,
        "created_at": "2019-03-14 09:34:05",
        "updated_at": "2019-03-14 09:49:21"
    }
}
```

24.删除文章
```
url:http://域名/api/admin/article_manager/edit_article
请求方法:post
json参数:
{
	"article_id":"2"  //文章id
}

返回:
{
    "code": 200,
    "message": "删除成功!",
    "data": []
}
```

25.获取用户协议列表
```
url:http://域名/api/admin/article_manager/get_agreements_list
请求方法:get
json参数:
{
	"page":1,  //必填 页码
	"size":1  //必填 数量
}

返回:
{
    "code": 200,
    "message": "获取用户协议列表成功!",
    "data": {
        "data": [
            {
                "num": 1,
                "article_id": 4,
                "article_title": "我是大帅哥",
                "publish_time": "2019-03-14 14:05:51"
            }
        ],
        "size": 1,
        "cur_page": 1,
        "total_page": 1,
        "total_size": 1
    }
}
```

26.获取系统文章列表
```
url:http://域名/api/admin/article_manager/get_system_article_list
请求方法:get
json参数:
{
	"page":1,  //必填 页码
	"size":1  //必填 数量
}

返回:
{
    "code": 200,
    "message": "获取系统文章列表成功!",
    "data": {
        "data": [
            {
                "num": 1,
                "article_id": 9,
                "article_title": "我是系统文章",
                "publish_time": "2019-03-14 14:12:29"
            },
            {
                "num": 2,
                "article_id": 10,
                "article_title": "我是系统文章",
                "publish_time": "2019-03-14 14:12:30"
            },
            {
                "num": 3,
                "article_id": 11,
                "article_title": "我是系统文章",
                "publish_time": "2019-03-14 14:12:33"
            }
        ],
        "size": 4,
        "cur_page": 1,
        "total_page": 1,
        "total_size": 3
    }
}
```

27.获取系统公告列表
```
url:http://域名/api/admin/article_manager/get_system_announcement_list
请求方法:get
json参数:
{
	"page":1,  //必填 页码
	"size":1  //必填 数量
}

返回:
{
    "code": 200,
    "message": "获取系统公告列表成功!",
    "data": {
        "data": [
            {
                "num": 1,
                "article_id": 13,
                "article_title": "我是系统公告1",
                "publish_time": "2019-03-14 14:21:05"
            },
            {
                "num": 2,
                "article_id": 14,
                "article_title": "我是系统公告2",
                "publish_time": "2019-03-14 14:21:08"
            }
        ],
        "size": 4,
        "cur_page": 1,
        "total_page": 1,
        "total_size": 2
    }
}
```

2x.获取反馈列表
```
url:http://域名/api/admin/feedback_manager/get_feedback_list
请求方法:get
json参数:
{
	"page":"1",  //页码  必填
	"size":"3"   //获取数量 必填
}

返回:
{
    "code": 200,
    "message": "获取回馈列表成功!",
    "data": {
        "data": [
            {
                "add_time": "2019-03-14 12:00:14",
                "member_id": "ruan11223344",
                "contact_way": "ruan4215@gmail.com",
                "user_message": "我账户密码不能修改",
                "user_type_str": "注册用户",
                "status_str": "垃圾反馈",
                "is_process": true,
                "is_spam": true
            },
            {
                "add_time": "2019-03-14 12:00:14",
                "member_id": "ruan11223344",
                "contact_way": "ruan4215@gmail.com",
                "user_message": "我账户密码不能xxx修改",
                "user_type_str": "注册用户",
                "status_str": "垃圾反馈",
                "is_process": false,
                "is_spam": true
            },
            {
                "add_time": "2019-03-14 12:00:14",
                "member_id": "ruan11223344",
                "contact_way": "ruan4215@gmail.com",
                "user_message": "我账户密码不能修改",
                "user_type_str": "注册用户",
                "status_str": "已处理",
                "is_process": true,
                "is_spam": null
            }
        ],
        "size": "3",
        "cur_page": "1",
        "total_page": 15,
        "total_size": 43
    }
}
```

2x.管理员处理反馈
```
url:http://域名/api/admin/feedback_manager/process_feedback
请求方法:post
json参数:
{
	"feedback_id":"5",  //反馈id 必填
	"is_spam":false,    //是否是垃圾反馈 ？ true 跟 false 两个值 必填
	"admin_message":"fdfds但打赏的撒大是"  //管理员反馈处理结果 is_span 为true时可不传
}
返回:
{
    "code": 200,
    "message": "处理成功!",
    "data": {
        "id": 5,
        "admin_id": null,
        "user_id": "7",
        "user_message": "我账户密码不能修改",
        "admin_message": "fdfds但打赏的撒大是",
        "is_process": true,
        "is_spam": false,
        "contact_way": "ruan4215@gmail.com",
        "deleted_at": null,
        "created_at": "2019-03-14 12:00:14",
        "updated_at": "2019-03-14 13:44:37"
    }
}
```



