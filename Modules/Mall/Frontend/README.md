# frontend

## Project setup
```
yarn install
```

### Compiles and hot-reloads for development
```
yarn run serve
```

### Compiles and minifies for production
```
yarn run build
```

### Lints and fixes files
```
yarn run lint
```


# Laravel + Vue CLI 3

This demo assumes you are serving this Laravel app via Valet at `laracon.test`. If you are serving the laravel app at a different local URL, modify it accordingly in `frontend/vue.config.js`.

### To Run the Frontend

``` sh
cd frontend
yarn # OR npm install
yarn serve # OR npm run serve

# build for production:
yarn build # OR npm run build
```

### Steps for Scaffolding From Scratch

1. Create Laravel Project

    ``` sh
    laravel new my-project
    cd my-project

    # remove existing frontend scaffold
    rm -rf package.json webpack.mix.js yarn.lock resources/assets
    ```

2. Create a Vue CLI 3 project in the Laravel app

    ``` sh
    vue create frontend
    # pick router
    ```

3. Configure Vue project

    Create `frontend/vue.config.js`:

    ``` js
    module.exports = {
      // proxy API requests to Valet during development
      devServer: {
        proxy: 'http://laracon.test'
      },

      // output built static files to Laravel's public dir.
      // note the "build" script in package.json needs to be modified as well.
      outputDir: '../public',

      // modify the location of the generated HTML file.
      // make sure to do this only in production.
      indexPath: process.env.NODE_ENV === 'production'
        ? '../resources/views/index.blade.php'
        : 'index.html'
    }
    ```

    Edit `frontend/package.json`:

    ``` diff
    "scripts": {
      "serve": "vue-cli-service serve",
    - "build": "vue-cli-service build",
    + "build": "rm -rf ../public/{js,css,img} && vue-cli-service build --no-clean",
      "lint": "vue-cli-service lint"
    },
    ```

4. Configure Laravel for single-page app.

    **routes/web.php**

    ``` php
    <?php

    Route::get('/{any}', 'SpaController@index')->where('any', '.*');
    ```

    **app/Http/Controllers/SpaController.php**

    ``` php
    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class SpaController extends Controller
    {
        public function index()
        {
            return view('index');
        }
    }
    ```
    
 # 接口文档
 
1.获取token
```
url:http://域名/api/auth/get_access_token
请求方法:post
请求参数说明:
参数:"grant_type",值:"password"    //类型
参数:"client_id",值:2              //客户端id（固定值)
参数:"client_secret",值::"LfmILOffY40xTlFbJT2Q0V8gWyyu99cwlElNPKrK"  //客户端秘钥（固定值)
参数:"username",值:"ruan4215@gmail.com"   //用户名
参数:"password",值:"seaer12345"           //密码
参数:"captcha",值:"sdww2"           //验证码
参数:"key",值:"$2y$10$9svXiMux2NGzd104cFYPFulbHViAw8r9G/s683Dxq8Xoq8x9iesGu"           //验证码接口中获取的key

返回成功的示例：
{
    "code": 200,
    "message": "成功!",
    "data": {
        "token_type": "Bearer",
        "expires_in": 1296000,
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjhhNjlkZmQ0YzlmNjkzMjhjNjI3MDMyMjU4OGY4YWNiODIyYjhhMTkxMmY5MTM0NDdmNmVkOWQ3MzQ4NjNmMzMzYjg2OGNiNDFjMzZlMTgzIn0.eyJhdWQiOiIyIiwianRpIjoiOGE2OWRmZDRjOWY2OTMyOGM2MjcwMzIyNTg4ZjhhY2I4MjJiOGExOTEyZjkxMzQ0N2Y2ZWQ5ZDczNDg2M2YzMzNiODY4Y2I0MWMzNmUxODMiLCJpYXQiOjE1NDc3ODE0OTEsIm5iZiI6MTU0Nzc4MTQ5MSwiZXhwIjoxNTQ5MDc3NDkxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.bjFXNNfa3BDRYay62WyA1clrgR7TFQ2QMg0y27TLhesSNNBhG4-NuFucVmYqOgiAR8cfq6C6ZLbujSNnm1JlfiHEqUAhtowW3SH3nLbopIGRZC7rXcEisZsGT_Bgd7VbRi5nRvGY76XxgMViZlNFD760XbYiTDM2J-MjFN-sVtSgh34NtxI5pisnzZrxnkSme40BxePHNCPPxcjHrZPkg2J0VTyhJwWsUPJXlQ5Rw9eAWU638y1wi-vybJ_KPMBsb-3IiIXIGHw3y-DXFc_2CgWLbFNv5Admh9G8ZbJwblv5iBwR1dpKMdiTEcyoEcvfT5eZCJVmFaNNX-Y49cbrOQeok34BTkNx3hk7M5HbsC3jxlS5XEhEOayGVLRrFtMiZDZLWCvQuYEdcWNQnuchWKH2eH6HQadvU4asag8dXDUIXPKBBQARATc4lrrpo-88MuWf-CQ1nf2omhMeOoY5aXuacYZrQ4imhDf-nWC2ixkBPe_D5X9nDw6euwLb23KNweycAdRLkRRrZA-O95b-potqoGNm26XmVLwu6KtHG4GeoPsQR3xhuoZPv3X1Qc4cK0bL6pJFXQfrIcPjN_isSyXcCH-04gQsGtbVYpg1TYqLN0CHwPT6PMToGd_-iuVOza1vDBxwEqVk4Lj2_S6fhfO6xO0M2UHnaUObp5up0VA",
        "refresh_token": "def50200ad68141d5e3cb3c82a4dd88fecddfe4eafaa8f9318b0fbaca89b23a82a165534b509e792f27c5d864edadac047888cdbcbde9a111d43476c2e37d0cef04f8d40f4d16a3f1baa834d95dd4b5eab5d1881ad93a97848ea32ef0237c978d248e34a188f11c462ab18c27726fb4c913d5f4b5282338b8ae550b6e0c860c474210664a1c8f8e37fd2743ffe701ac9e488691ca92436097aeac99a6dc2e86b8cbd005ea5770e552a88f47cd70d7e60991dedaeccf540c9cdb86cd02dd34001778660d021f4ba5ba11e181201c296c2707d378ab255682b8a44c48cec852448c658e588a10f720d9d7df659419bcbf7e511867e8c25aabcc92fe763b95e6a4e308dc6324163dbb8a9f9835ad109bf96ba0e74e531f91329fc3e01943002ed5ca8ff165745c5844fb4ab5ec7da802d50e16e65db2b8f65177e94245a108b7a2001f6859d27d025c36b388d941e9da60051e10955c20aae3a9ccd7c42c3fd40f8a6"
    }
}

注意:以表单提交参数传值！
```
2.刷新token
```
url:http://域名/api/auth/get_access_token
请求方法:post
请求参数说明:
参数:"grant_type",值:"refresh_token"    //类型
参数:"client_id",值:2              //客户端id（固定值)
参数:"client_secret",值::"LfmILOffY40xTlFbJT2Q0V8gWyyu99cwlElNPKrK"  //客户端秘钥（固定值)
参数:"refresh_token",值:"ruan4215@gmail.com"   //刷新tonken值 从获取token接口中获取

注意:以表单提交参数传值！
```

3.获取用户信息
```
url:http://域名/api/auth/get_user_info
请求方法:post
请求头参数说明:  //注意是请求头 
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token"

注意:只有请求头参数,无其他参数。
```
 
 
4.获取验证码
```
url:http://域名/api/utils/get_captcha
请求方法:get
参数:无
返回的数据:
{
          "code": 200,
          "message": "获取验证码成功!",
          "data": {
              "sensitive": false,
              "key": "$2y$10$N9pB3ZK4/aWaLhJyQwc62.SsbkBA1ao7gbSZEBsiDpHtOBbnJGjAK",
              "img": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAkCAYAAABCKP5eAAAVZklEQVR4nI2ceZAkWV3HP3lWVVd1dfXdMz332cPuzLCHsOyOK4cCuyGrEKBAEAEGgrugghKsBIuyYKAcIRIgp6FAiBKIgoRyGBDAsiMLe19z99wzPX1MX3VmVuXhH9Uv65evqod9ERlVlfnyvd/7fX/3e93G0aNHY9d1cRwH27YxDAPTNDFNE8dxcBwHy7IAiKKIMAwJgoBWq0Wz2SQMQ+I4Tt4zDAPLspKxAAzDwLbt5F4URckcYRjSaDTwPI8gCJIriqJkLNXXMIzk...........
          }
      }
      
请使用base64解码图片
```

 
 
5.注册邮件发送
```
url:http://域名/api/auth/send_register_email
请求方法:post
参数:"member_id",值:"useradmin"    //用户名 必填
参数:"captcha",值:"2dswkds"   //验证码 必填
参数:"key",值:"$2y$10$N9pB3ZK4/aWaLhJyQwc62.SsbkBA1ao7gbSZEBsiDpHtOBbnJGjAK"     //验证码接口中的key 必填
参数:"email",值:"ruan4215@gmail.com"   //邮箱 必填
参数:"account_type",值:"0 或者 1"   //账户类型  0中国卖家 1肯尼亚卖家 必填
参数:"i_agree",值:"true"   //同意协议  1 或者 "1" 或者 true 必填

返回:
{
    "code": 200,
    "message": "邮件发送成功!",
    "data": {
        "redirect_to": null  //如果没有找到邮箱地址 则返回null
    }
}
```

6.省份列表获取
```
url:http://域名/api/utils/get_provinces_list
请求方法:get
参数:"country_code",值:"cn"    //国家代码 cn 或者 ke 必填

返回:

{
    "code": 200,
    "message": "成功!",
    "data": [
        {
            "province_id": 127,
            "name": "Central"
        },
        {
            "province_id": 124,
            "name": "Coast"
        },
        {
            "province_id": 126,
            "name": "Eastern"
        },
        {
            "province_id": 131,
            "name": "Nairobi"
        },
        {
            "province_id": 125,
            "name": "North Eastem"
        },
        {
            "province_id": 130,
            "name": "Nyanza"
        },
        {
            "province_id": 128,
            "name": "Rift Valley"
        },
        {
            "province_id": 129,
            "name": "Westerm"
        }
    ]
}

```

7.城市列表获取
```
url:http://域名/api/utils/get_city_list
请求方法:get
参数:"province_id",值:"129"    //省份id 必填

返回:
{
    "code": 200,
    "message": "成功!",
    "data": [
        {
            "city_id": 3775,
            "name": "Nyandarua"
        },
        {
            "city_id": 3776,
            "name": "Nyeri"
        },
        {
            "city_id": 3777,
            "name": "Kirinyaga"
        },
        {
            "city_id": 3778,
            "name": "Muranga"
        },
        {
            "city_id": 3779,
            "name": "Kiambu"
        }
    ]
}
```

7.注册请求前置接口 
```
说明:此接口为了判断注册页面是否为第一次被访问该接口,如果接口提示过期，页面也要展示过期提醒。

url:http://域名/api/auth/check_register_status
请求方法:post
参数:"uuid",值:"08b7b510-18a3-11e9-bc7a-db13b186ec35"    //点开邮件发送的注册链接时url参数中的uuid 必填

返回正确:
{
"code":200,
"message":"you can continue to register!",
"data":{"account_type":1,"member_id":null,"email":"bbs888@vip.qq.com"}
}

返回错误:
{
"code":400,"message":"this page is expired!{\"uuid\":[\"The selected uuid is invalid.\"]}","data":[]
}

重要！！！！！！！ 错误返回提示过期时 要跳转到过期提醒页面！
```

8.注册接口 
```
url:http://域名/api/auth/register
请求方法:post
参数:"password",值:"Qq42158888"     //密码 必填
参数:"password_confirmation",值:"Qq42158888"  //重复密码 必填
参数:"account_type",值:"0 或者 1"     //注意！如果用户切换身份 则account_type 也随之切换而并非 邮件发送的注册链接时url参数中的u_from 其中 u_from=cn 时account_type 为 0  为ke时 account_type 为 1 切换后随之变动 必填
参数:"sex",值:"Miss,Mr,Mrs 其中一个"     //性别 必填
参数:"company_name",值:"XX company"     //公司名称  必填
参数:"company_name_in_china",值:"飞翔有限公司"     //公司中文名 非必填 中国卖家时传
参数:"china_business_license",值:"中国"     //中国营业执照 非必填 中国卖家时传
参数:"business_license_img",值:"文件上传"     // file格式上传  非必填 中国卖家时传
参数:"contact_full_name",值:"Jason Ruan"     //全名 必填
参数:"mobile_phone",值:"+8613672009476"     //手机号 必填
参数:"chinese_name",值:"阮俊森"     //中文名 非必填
参数:"city_id",值:158    //城市id  从接口获取的城市id 非必填
参数:"province_id",值:56     //省份id 从接口获取的省份id 非必填
参数:"uuid",值:"08b7b510-18a3-11e9-bc7a-db13b186ec35"     //邮件发送的注册链接时url参数中的uuid 必填

返回:

```

9.获取商品分类  2019-02-15修改路由
```
url:http://域名/api/shop/category/get_category

请求方法:get
参数:"无"    
返回:
{
"code": 200,
"message": "成功!",
"data": [
{
"id": 1,
"name": "Auto & Transportation",
"_lft": 1,
"_rgt": 252,
"parent_id": null,
"created_at": "2019-01-21 13:46:51",
"updated_at": "2019-01-21 13:46:55",
"sort": 0,
"children": []
},..............
```

10.创建询盘消息
```
url:http://域名/api/message/create_message

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"to_af_id",值:"AF_CN_7a49b34079"   //必填  发送给用户的唯一识别id
参数:"attachment_list",值:"多文件上传"   //必填   附件上传接口 以file格式上传 表单加 [] 否则不予通过 ,就算一个文件也是已数组形式传输 

参数:"subject",值:"我需要大量的香蕉 可以聊一下嘛？"  //必填 询盘的主题 
参数:"purchase_quantity",值:"24"  //必填 需要的数量
参数:"purchase_unit",值:"斤"  //必填 需要的数量的单位
参数:"content",值:"香蕉是个好东西 真好吃！"  //必填 发送的主体内容
参数:"extra_request[]",值:"{"Price" :true}"  //非必填 额外要求 值要求:json字符串对象

返回:
{
    "code": 200,
    "message": "发布消息成功",
    "data": {
        "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
        "extends": {
            "extra_request": [
                {
                    "Price": true
                },
                {
                    "Specifications": true
                },
                {
                    "Company Profile": true
                }
            ],
            "purchase_quantity": "24",
            "purchase_unit": "斤"
        },
        "updated_at": "2019-01-24 13:49:10",
        "created_at": "2019-01-24 13:49:10",
        "id": 28
    }
}
```

11.清空已经删除的消息（清空回收站)  // 2019-02-13 此接口已删除！

```
url:http://域名/api/message/empty_message

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无普通参数~

返回:
{
    "code": 200,
    "message": "清空成功!",
    "data": []
}
```

12.获取已经删除过的消息
```
url:http://域名/api/message/delete_message

请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无普通参数~

返回:
{
    "code": 200,
    "message": "成功!",
    "data": [
        {
            "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
            "content": "wawawwawa我是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是",
            "message_id": 32,
            "thread_id": 27,
            "send_at": {
                "date": "2019-01-24 13:48:37.000000",
                "timezone_type": 3,
                "timezone": "PRC"
            },
            "send_from_ip": "127.0.0.*",
            "send_by_af_id": "AF_CN_c1dce03047",
            "send_to_af_id": "AF_CN_c1dce03047",
            "send_by_name": "wang ni ma",
            "send_to_name": "wang ni ma",
            "send_country": "cn",
            "extra_request": [
                {
                    "Price": true
                },
                {
                    "Specifications": true
                },
                {
                    "Company Profile": true
                }
            ],
            "purchase_quantity": "24 斤",
            "attachment_list": [
                {
                    "下载.png": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891665374900.png"
                },
                {
                    "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891773900395.jpeg"
                }
            ],
            "other_party_is_read": true,
            "other_party_is_reply": false,
            "type": "outbox"  //注意这里 outbox 是发件箱的消息噢~
        }
    ]
}
```

12.回复消息
```
url:http://域名/api/message/reply_message

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"message_id",值:"32"   //必填  要回复的消息id
参数:"attachment_list",值:"多文件上传"   //必填   附件上传接口 以file格式上传 表单加 [] 否则不予通过 ,就算一个文件也是已数组形式传输 
参数:"quote_message_id",值:"35"   //引用消息的id   非必填
参数:"content",值:"非洲香蕉大 真好吃！！"  //必填 发送的主体内容

返回:
{
    "code": 200,
    "message": "成功!",
    "data": []
}
```

13.获取发件箱消息
```
url:http://域名/api/message/outbox_message

请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无普通参数

返回:
{
    "code": 200,
    "message": "成功!",
    "data": {
        "all": [
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "你要多少肉肉啊1111",
                "message_id": 35,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 16:11:58.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03047",
                "send_to_af_id": "AF_CN_c1dce03043",
                "send_by_name": "wang ni ma",
                "send_to_name": "王尼玛",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03047/attachment/154831751852539124.jpeg"
                    }
                ],
                "other_party_is_read": false,
                "other_party_is_reply": false,
                "quote_message": [],
                "type": "outbox"
            },
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "你要多少肉肉啊2222",
                "message_id": 36,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 16:14:59.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03047",
                "send_to_af_id": "AF_CN_c1dce03043",
                "send_by_name": "wang ni ma",
                "send_to_name": "王尼玛",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03047/attachment/154831769846084917.jpeg"
                    }
                ],
                "other_party_is_read": true,
                "other_party_is_reply": false,
                "quote_message": [
                    {
                        "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                        "content": "wawawwawa我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是",
                        "message_id": 32,
                        "thread_id": 27,
                        "send_at": {
                            "date": "2019-01-24 13:48:37.000000",
                            "timezone_type": 3,
                            "timezone": "PRC"
                        },
                        "send_from_ip": "127.0.0.*",
                        "send_by_af_id": "AF_CN_c1dce03043",
                        "send_to_af_id": "AF_CN_c1dce03047",
                        "send_by_name": "王尼玛",
                        "send_to_name": "wang ni ma",
                        "send_country": "cn",
                        "extra_request": [
                            {
                                "Price": true
                            },
                            {
                                "Specifications": true
                            },
                            {
                                "Company Profile": true
                            }
                        ],
                        "purchase_quantity": "24 斤",
                        "attachment_list": [
                            {
                                "下载.png": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891665374900.png"
                            },
                            {
                                "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891773900395.jpeg"
                            }
                        ],
                        "other_party_is_read": true,
                        "other_party_is_reply": true,
                        "quote_message": [
                            {
                                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                                "content": "你要多少肉肉啊1111",
                                "message_id": 35,
                                "thread_id": 27,
                                "send_at": {
                                    "date": "2019-01-24 16:11:58.000000",
                                    "timezone_type": 3,
                                    "timezone": "PRC"
                                },
                                "send_from_ip": "127.0.0.*",
                                "send_by_af_id": "AF_CN_c1dce03047",
                                "send_to_af_id": "AF_CN_c1dce03043",
                                "send_by_name": "wang ni ma",
                                "send_to_name": "王尼玛",
                                "send_country": "cn",
                                "extra_request": [
                                    {
                                        "Price": true
                                    },
                                    {
                                        "Specifications": true
                                    },
                                    {
                                        "Company Profile": true
                                    }
                                ],
                                "purchase_quantity": "24 斤",
                                "attachment_list": [
                                    {
                                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03047/attachment/154831751852539124.jpeg"
                                    }
                                ],
                                "other_party_is_read": false,
                                "other_party_is_reply": false,
                                "quote_message": [],
                                "type": "outbox"
                            }
                        ],
                        "type": "outbox"
                    }
                ],
                "type": "outbox"
            }
        ],
        "unread": [
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "你要多少肉肉啊1111",
                "message_id": 35,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 16:11:58.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03047",
                "send_to_af_id": "AF_CN_c1dce03043",
                "send_by_name": "wang ni ma",
                "send_to_name": "王尼玛",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03047/attachment/154831751852539124.jpeg"
                    }
                ],
                "other_party_is_read": false,
                "other_party_is_reply": false,
                "quote_message": [],
                "type": "outbox"
            }
        ],
        "read": [
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "你要多少肉肉啊2222",
                "message_id": 36,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 16:14:59.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03047",
                "send_to_af_id": "AF_CN_c1dce03043",
                "send_by_name": "wang ni ma",
                "send_to_name": "王尼玛",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03047/attachment/154831769846084917.jpeg"
                    }
                ],
                "other_party_is_read": true,
                "other_party_is_reply": false,
                "quote_message": [
                    {
                        "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                        "content": "wawawwawa我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是",
                        "message_id": 32,
                        "thread_id": 27,
                        "send_at": {
                            "date": "2019-01-24 13:48:37.000000",
                            "timezone_type": 3,
                            "timezone": "PRC"
                        },
                        "send_from_ip": "127.0.0.*",
                        "send_by_af_id": "AF_CN_c1dce03043",
                        "send_to_af_id": "AF_CN_c1dce03047",
                        "send_by_name": "王尼玛",
                        "send_to_name": "wang ni ma",
                        "send_country": "cn",
                        "extra_request": [
                            {
                                "Price": true
                            },
                            {
                                "Specifications": true
                            },
                            {
                                "Company Profile": true
                            }
                        ],
                        "purchase_quantity": "24 斤",
                        "attachment_list": [
                            {
                                "下载.png": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891665374900.png"
                            },
                            {
                                "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891773900395.jpeg"
                            }
                        ],
                        "other_party_is_read": true,
                        "other_party_is_reply": true,
                        "quote_message": [
                            {
                                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                                "content": "你要多少肉肉啊1111",
                                "message_id": 35,
                                "thread_id": 27,
                                "send_at": {
                                    "date": "2019-01-24 16:11:58.000000",
                                    "timezone_type": 3,
                                    "timezone": "PRC"
                                },
                                "send_from_ip": "127.0.0.*",
                                "send_by_af_id": "AF_CN_c1dce03047",
                                "send_to_af_id": "AF_CN_c1dce03043",
                                "send_by_name": "wang ni ma",
                                "send_to_name": "王尼玛",
                                "send_country": "cn",
                                "extra_request": [
                                    {
                                        "Price": true
                                    },
                                    {
                                        "Specifications": true
                                    },
                                    {
                                        "Company Profile": true
                                    }
                                ],
                                "purchase_quantity": "24 斤",
                                "attachment_list": [
                                    {
                                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03047/attachment/154831751852539124.jpeg"
                                    }
                                ],
                                "other_party_is_read": false,
                                "other_party_is_reply": false,
                                "quote_message": [],
                                "type": "outbox"
                            }
                        ],
                        "type": "outbox"
                    }
                ],
                "type": "outbox"
            }
        ]
    }
}
```


14.获取收件箱消息
```
url:http://域名/api/message/inbox_message

请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无普通参数
返回:
{
    "code": 200,
    "message": "成功",
    "data": {
        "all": [
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "wawawwawa我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是",
                "message_id": 32,
                "participant_id": 29,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 13:48:37.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "is_read": true,
                "is_reply": false,
                "from_other_party_reply“: false,
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03043",
                "send_by_name": "王尼玛",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "下载.png": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891665374900.png"
                    },
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891773900395.jpeg"
                    }
                ],
                "type": "inbox"
            },
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "你要多少肉肉啊1111",
                "message_id": 35,
                "participant_id": 32,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 16:11:58.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "is_read": false,
                "is_reply": false,
                "from_other_party_reply“: false,
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03047",
                "send_by_name": "wang ni ma",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03047/attachment/154831751852539124.jpeg"
                    }
                ],
                "type": "inbox"
            }
        ],
        "unread": [
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "你要多少肉肉啊1111",
                "message_id": 35,
                "participant_id": 32,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 16:11:58.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "is_read": false,
                "is_reply": false,
                "from_other_party_reply“: false,
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03047",
                "send_by_name": "wang ni ma",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03047/attachment/154831751852539124.jpeg"
                    }
                ],
                "type": "inbox"
            }
        ],
        "pending_for_reply": [
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "wawawwawa我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是",
                "message_id": 32,
                "participant_id": 29,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 13:48:37.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "is_read": true,
                "is_reply": false,
                "from_other_party_reply“: false,
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03043",
                "send_by_name": "王尼玛",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "下载.png": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891665374900.png"
                    },
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891773900395.jpeg"
                    }
                ],
                "type": "inbox"
            },
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "你要多少肉肉啊1111",
                "message_id": 35,
                "participant_id": 32,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 16:11:58.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "is_read": false,
                "is_reply": false,
                "from_other_party_reply“: false,
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03047",
                "send_by_name": "wang ni ma",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03047/attachment/154831751852539124.jpeg"
                    }
                ],
                "type": "inbox"
            }
        ]
    }
}

```

15.获取垃圾询盘消息

```
url:http://域名/api/message/spam_message

请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无普通参数

返回：
{
    "code": 200,
    "message": "成功",
    "data": {
        "all": [
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "wawawwawa我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是",
                "message_id": 32,
                "participant_id": 29,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 13:48:37.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "is_read": true,
                "is_reply": false,
                "from_other_party_reply“: false,
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03043",
                "send_by_name": "王尼玛",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "下载.png": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891665374900.png"
                    },
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891773900395.jpeg"
                    }
                ],
                "is_flag": false,
                "type": "inbox"
            }
        ]
    }
}
```


16.获取标旗询盘消息

```
url:http://域名/api/message/flag_message

请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无普通参数

返回：
{
    "code": 200,
    "message": "成功",
    "data": {
        "all": [
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "你要多少肉肉啊1111",
                "message_id": 35,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 16:11:58.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03047",
                "send_to_af_id": "AF_CN_c1dce03047",
                "send_by_name": "wang ni ma",
                "send_to_name": "wang ni ma",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03047/attachment/154831751852539124.jpeg"
                    }
                ],
                "other_party_is_read": false,
                "other_party_is_reply": false,
                "quote_message": [],
                "is_flag": true,
                "type": "outbox"
            },
            {
                "subject": "wawawwawa我需要一些肉肉肉肉肉肉肉",
                "content": "wawawwawa我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是我真的很喜欢肉肉啊 你知道吗搜索是是是  是 是是是是",
                "message_id": 32,
                "participant_id": 29,
                "thread_id": 27,
                "send_at": {
                    "date": "2019-01-24 13:48:37.000000",
                    "timezone_type": 3,
                    "timezone": "PRC"
                },
                "is_read": true,
                "is_reply": false,
                "from_other_party_reply“: false,
                "send_from_ip": "127.0.0.*",
                "send_by_af_id": "AF_CN_c1dce03043",
                "send_by_name": "王尼玛",
                "send_country": "cn",
                "extra_request": [
                    {
                        "Price": true
                    },
                    {
                        "Specifications": true
                    },
                    {
                        "Company Profile": true
                    }
                ],
                "purchase_quantity": "24 斤",
                "attachment_list": [
                    {
                        "下载.png": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891665374900.png"
                    },
                    {
                        "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_c1dce03043/attachment/154830891773900395.jpeg"
                    }
                ],
                "is_flag": true,
                "type": "inbox"
            }
        ]
    }
}
```

17.标记标旗询盘消息

```
url:http://域名/api/message/mark_flag_message

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

普通参数 注意 这是一个翻转接口............
以下是普通参数 ↓
参数:"participant_id",值:"32"   //type为inbox时必填  收件id
参数:"message_id",值:"32"   //type为outbox时必填  发件id
参数:"type",值:"inbox" or “”outbox"   //必填  


返回：
{
    "code": 200,
    "message": "成功!",
    "data": [
        [
            {
                "id": 32,
                "thread_id": 27,
                "user_id": 7,
                "last_read": null,
                "created_at": "2019-01-24 16:11:58",
                "updated_at": "2019-01-25 10:16:33",
                "deleted_at": null,
                "extends": {
                    "is_flag": true,
                    "is_spam": false,
                    "is_reply": false,
                    "from_other_party_reply“: false,
                    "message_id": 35,
                    "soft_deleted_at": false,
                    "true_deleted_at": false
                }
            }
        ]
    ]
}
```


18.标记垃圾询盘消息

```
url:http://域名/api/message/mark_spam_message

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

普通参数 注意 这是一个翻转接口............
以下是普通参数 ↓
参数:"thread_id_list[]",值:"32"   //必填 注意 会话id列表 这个参数传数组
参数:"action",值:"cancel" 或者 "mark"   //必填 动作清除或者标记


返回：
{
    "code": 200,
    "message": "成功!",
    "data": []
}
```


19.标记删除消息

```
url:http://域名/api/message/mark_delete_message

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"participants_id_list[]",值:"32"   //type为inbox时必填
参数:"messages_id_list[]",值:"32"   //type为outbox时必填
参数:"type",值:"inbox" 或者 "outbox"   //必填 删除哪的消息 收件箱或者发件箱
参数:"action",值:"mark" 或者 "cancel"   //必填 动作清除或者标记


返回：
{
    "code": 200,
    "message": "删除消息成功!",
    "data": []
}
```

20.标记为已读消息

```
url:http://域名/api/message/mark_read_message

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"participant_id",值:"32"   //收件消息id

返回：
{
    "code": 200,
    "message": "成功!",
    "data": []
}
```


21.清空删除的消息 // 2019-02-13 此接口已删除！

```
url:http://域名/api/message/empty_message

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无普通参数

返回：
{
    "code": 200,
    "message": "清空成功!",
    "data": []
}
```
21.获取消息详情   

```
url:http://域名/api/message/message_info

请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"message_id",值:"32"   //type为outbox时必填
参数:"participant_id",值:"32"   //type为inbox时必填
参数:"type",值:"inbox" 或者 "outbox"   //必填 删除哪的消息 收件箱或者发件箱

返回：
{
    "code": 200,
    "message": "成功!",
    "data": [
        {
            "subject": "我需要大量的香蕉 可以聊一下嘛？",
            "content": "香蕉是个好东西 真好吃",
            "message_id": 42,
            "thread_id": 41,
            "send_at": {
                "date": "2019-01-25 13:39:23.000000",
                "timezone_type": 3,
                "timezone": "PRC"
            },
            "send_from_ip": "127.0.0.*",
            "send_by_af_id": "AF_CN_c1dce03043",
            "send_to_af_id": "AF_CN_7a49b34079",
            "send_by_name": "王尼玛",
            "send_to_name": "QWEQE",
            "send_country": "cn",
            "extra_request": null,
            "purchase_quantity": "24 斤",
            "attachment_list": null,
            "quote_message": null,
            "type": "outbox"
        }
    ]
}
```

2019-02-13 新增 查询邮箱通知设置
```
url:http://域名/api/message/email_notification_status

请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无普通参数

返回：
{
    "code": 200,
    "message": "获取邮箱通知状态成功!",
    "data": {
        "email_notification": true
    }
}
```

2019-02-13 新增 设置邮箱通知
```
url:http://域名/api/message/set_email_notification

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无普通参数  注意该接口是一个翻转接口。

返回：
{
    "code": 200,
    "message": "设置成功!",
    "data": []
}
```

2019-02-13 新增 永久软删除消息
```
url:http://域名/api/message/confirm_delete_message

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"participants_id_list[]",值:"32"   //必填 没有传 []空数组  inbox 的 id
参数:"messages_id_list[]",值:"32"   //必填 没有传 []空数组 outbox 的 id

返回：
{
    "code": 200,
    "message": "永久删除成功!",
    "data": []
}
```


22.上传图片到相册目录
```
url:http://域名/api/album/upload_img_to_album

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"images[]",值:"单个或者多个文件"   //以数组形式传输 file。

返回：
{
    "code": 200,
    "message": "成功!",
    "data": [
        {
            "960 (2).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_7a49b34079/album/154994802072479997.jpeg"
        },
        {
            "960 (1).jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_7a49b34079/album/15499480207194725.jpeg"
        },
        {
            "960.jpeg": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_7a49b34079/album/154994802178413506.jpeg"
        }
    ]
}
```

23.保存上传的图片到相册
```
url:http://域名/api/album/save_img_to_album

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
json参数:"photo_name_url_list",值:"[{"image1":"/mall/users/AF_CN_c1dce03043/album/154993909864833423.jpg"},{"image1":"/mall/users/AF_CN_c1dce03043/album/154993909864833423.jpg"},{"image3":"/mall/users/AF_CN_c1dce03043/album/154993909864833423.jpg"}]"   //关联数组格式 可以多个或者单个 但必须是关联数组 以 自定义图片名->图片url的格式  （图片url从22号接口获取)
"album_id",值:"6"   //相册id

返回：
{
    "code": 200,
    "message": "保存成功!",
    "data": []
}
```

24.创建相册
```
url:http://域名/api/album/create_album

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"album_name",值:"相册1"   //相册名称
参数:"album_descriptiond",值:"这里是相册描述"   //相册描述信息

返回：
{
    "code": 200,
    "message": "创建相册成功!",
    "data": []
}
```

25.删除相册
```
url:http://域名/api/album/delete_album

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"album_id",值:"3"   //相册id

返回：
{
    "code": 200,
    "message": "删除相册成功!",
    "data": []
}
```

26.修改相册
```
url:http://域名/api/album/edit_album

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"album_id",值:"3"   //相册id
参数:"album_name",值:"相册名称1"   //相册名称
参数:"album_description",值:"此处是相册描述"   //相册描述

返回：
{
    "code": 200,
    "message": "更新相册成功!",
    "data": []
}
```

27.获取相册中的图片列表
```
url:http://域名/api/album/album_photo_list

请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"album_id",值:"3"   //相册id

返回：
{
    "code": 200,
    "message": "获取相册图片列表成功!",
    "data": [
        {
            "id": 3,
            "album_id": 3,
            "photo_name": "dd3",
            "photo_url": "https://iocaffcdn.phphub.org/uploads/banners/5LNCgFww4UqiB4Jf4yPl.jpg!/both/554x132",
            "created_at": null,
            "updated_at": "2019-02-11 16:11:46"
        },
        {
            "id": 4,
            "album_id": 3,
            "photo_name": "dd4",
            "photo_url": "https://iocaffcdn.phphub.org/uploads/banners/5LNCgFww4UqiB4Jf4yPl.jpg!/both/554x132",
            "created_at": "2019-02-11 14:12:40",
            "updated_at": null
        },
        {
            "id": 5,
            "album_id": 3,
            "photo_name": "dd4",
            "photo_url": "https://iocaffcdn.phphub.org/uploads/banners/5LNCgFww4UqiB4Jf4yPl.jpg!/both/554x132",
            "created_at": "2019-02-11 14:35:01",
            "updated_at": null
        }
    ]
}
```

28.修改或删除图片
```
url:http://域名/api/album/modify_photos

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

以下是普通参数 ↓
参数:"photo_id_list[]",值:"[3,4,5,6]"   //必填 数组格式 图片id列表（图片id可以从27号接口中获取。)
参数:"action",值:"move"   //必填 动作 move 或者 delete 
参数:"to_album_id",值:"3"   //移动到哪个相册id 当action为move时必填

返回：
{
    "code": 200,
    "message": "移动图片成功!",
    "data": []
}
```


29.获取相册id列表
```
url:http://域名/api/album/album_list

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无普通参数 

返回：
{
    "code": 200,
    "message": "成功!",
    "data": [
        {
            "id": 1,
            "album_name": "Default Album",
            "album_description": null,
            "user_id": 13,
            "created_at": "2019-02-11 11:18:02",
            "updated_at": "2019-02-11 11:18:02"
        },
        {
            "id": 2,
            "album_name": "fffffff",
            "album_description": "fgfffff",
            "user_id": 13,
            "created_at": "2019-02-11 11:22:24",
            "updated_at": "2019-02-11 11:50:22"
        },
        {
            "id": 3,
            "album_name": "f",
            "album_description": null,
            "user_id": 13,
            "created_at": null,
            "updated_at": null
        },
        {
            "id": 7,
            "album_name": "小王",
            "album_description": "大王",
            "user_id": 13,
            "created_at": "2019-02-12 13:11:53",
            "updated_at": "2019-02-12 13:19:08"
        }
    ]
}
```


30.获取商品分组列表
```
url:http://域名/api/shop/product_group/product_group_list

请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无普通参数 

返回：
{
    "code": 200,
    "message": "获取商品分组成功!",
    "data": [
        {
            "id": 15,
            "user_id": 13,
            "group_name": "嘿嘿嘿ddd",
            "parent_id": 0,
            "show_home_page": true,
            "sort": 22,
            "created_at": "2019-02-14 16:40:45",
            "updated_at": "2019-02-14 16:40:45",
            "deleted_at": null,
            "children": null
        },
        {
            "id": 16,
            "user_id": 13,
            "group_name": "嘿嘿嘿dddd",
            "parent_id": 0,
            "show_home_page": true,
            "sort": 22,
            "created_at": "2019-02-14 16:43:50",
            "updated_at": "2019-02-14 16:43:50",
            "deleted_at": null,
            "children": null
        }
    ]
}
```

31.创建商品分组
```
url:http://域名/api/shop/product_group/create_products_group

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

json参数:
{
	"group_parent_id":null,   //父分组id 必填 没有为null
	"group_name":"嘿嘿嘿ddddd", //必填 分组名称
	"show_home_page":true,  //必填 布尔类型 是否在首页显示
	"sort":22   // 必填 排序 数字 不排序 填0
} 

返回：
{
    "code": 200,
    "message": "创建分组成功!",
    "data": []
}
```

32.修改商品分组
```
url:http://域名/api/shop/product_group/edit_products_group

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

json参数:
{
	"product_group_id":17,  //分组id 必填
	"group_name":"嘿嘿嘿dddddfffffff",  //修改后的分组名称 必填
	"show_home_page":true,  //必填 布尔类型 是否在首页显示
	"sort":22  //必填 排序 数字 不排序 填0
}

返回：
{
    "code": 200,
    "message": "更新商品分组成功!",
    "data": []
}
```


33.删除商品分组
```
url:http://域名/api/shop/product_group/edit_products_group

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

json参数:
{
"product_group_id":17  //分组id 必填
} 

返回：
{
    "code": 200,
    "message": "分组删除成功! 分组ID：17",
    "data": []
}
```


34.搜索关键词获取分类列表
```
url:http://域名/api/shop/category/search_category

请求方法:get
json参数:
{"keywords":"玩具"} //必填 关键词

 
返回:
{
    "code": 200,
    "message": "搜索关键词分类成功!",
    "data": [
        {
            "name": "Hotel Products > Room supplies > Towel",
            "categories_id": 382
        }
    ]
}
```


35.获取分类的子分类列表
```
url:http://域名/api/shop/category/get_category_child

请求方法:get
json参数:
{"categories_id":1} //必填 分类id

 
返回:
{
    "code": 200,
    "message": "获取子分类成功!",
    "data": [
        {
            "id": 2,
            "name": "Engine Parts",
            "sort": 0
        },
        {
            "id": 26,
            "name": "Transmission Parts",
            "sort": 0
        },
        {
            "id": 37,
            "name": "Chassis Parts",
            "sort": 0
        },
        {
            "id": 54,
            "name": "Body & Interiorand Exterior Parts",
            "sort": 0
        },
        {
            "id": 81,
            "name": "Maintenance & Modification Supplies",
            "sort": 0
        },
        {
            "id": 98,
            "name": "Auto Repair Tool",
            "sort": 0
        }
    ]
}
```

36.获取分类的父分类
```
url:http://域名/api/shop/category/get_category_parent

请求方法:get
json参数:
{"categories_id":3} //必填 分类id
 
返回:
{
    "code": 200,
    "message": "获取父分类成功!",
    "data": {
        "id": 2,
        "name": "Engine Parts",
        "sort": 0
    }
}
```

37.获取根分类列表
```
url:http://域名/api/shop/category/get_category_root

请求方法:get
没有参数

返回:
{
    "code": 200,
    "message": "获取根分类成功!",
    "data": [
        {
            "id": 1,
            "name": "Auto & Transportation",
            "sort": 0
        },
        {
            "id": 127,
            "name": "Construction",
            "sort": 0
        },
        {
            "id": 199,
            "name": "Home Furniture",
            "sort": 0
        },
        {
            "id": 275,
            "name": "Household Appliances",
            "sort": 0
        },
        {
            "id": 311,
            "name": "Lights",
            "sort": 0
        },
        {
            "id": 348,
            "name": "Hotel Products",
            "sort": 0
        },
        {
            "id": 405,
            "name": "Fabric Material",
            "sort": 0
        },
        {
            "id": 466,
            "name": "Metal Parts & Tools",
            "sort": 0
        },
        {
            "id": 532,
            "name": "Packaging",
            "sort": 0
        },
        {
            "id": 540,
            "name": "Idle Item",
            "sort": 0
        },
        {
            "id": 546,
            "name": "Food & Beverage / Agriculture",
            "sort": 0
        }
    ]
}
```

38.发送重置密码邮件
```
url:http://域名/api/auth/send_reset_password_email

请求方法:post
json参数
{
	"member_id_or_email":"admin",  //必填 member_id 或者 邮箱
	"key":"$2y$10$Q20AAPEs3TAtx/Kl/bKKIeDOVe7x3rXRJTy2Wy4dWyY0Q3mRwzKjq",   //验证码key
	"captcha":"x7fpb"  //验证码
}

返回:
{
    "code": 200,
    "message": "发送重置密码邮件成功!",
    "data": {
        "redirect_to": "http://mail.google.com"
    }
}

PS::token在邮件的链接中 ?token=bKKIeDOVe7x3rXRJTy2Wy4dWyY0Q3mRwzKjq
```

38.获取重置密码的member_id
```
url:http://域名/api/auth/get_reset_password_member_id

请求方法:get
json参数
{
"token":"f76b70e50f82c4c6fd728117c487b4e2"  //token必填
}

返回:
{
    "code": 200,
    "message": "获取member_id成功!",
    "data": {
        "member_id": "admin"
    }
}
```

39.提交重置密码
```
url:http://域名/api/auth/reset_password

请求方法:get
json参数
{
"token":"c7c42b0ae91816101bd7fea8887bc48a",  //token必填
"password":"123456",  //新密码
"password_confirmation":"123456"  //新重复密码
}

返回:
{
    "code": 200,
    "message": "恭喜!重置密码成功!",
    "data": []
}
```


40.上传发布商品的图片
```
url:http://域名/api/shop/product/upload_product_img

请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填
form-data 传值

参数:
product_img //上传的图片 必须 只能有一个图片文件 不能超过1024kb 
where  //必填 商品哪里的图  只能是 main 1 2 3 4 这5个值

返回:
{
    "code": 200,
    "message": "上传成功!",
    "data": {
        "img_path": {
            "960 (2).jpeg": "mall/users/AF_CN_7a49b34079/product/155047099099801852.jpeg"  //原始文件名+文件path
        },
        "img_url": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_7a49b34079/product/155047099099801852.jpeg",  //直接可以访问的url
        "where": "main" //商品哪里的图
    }
}
```


41.发布商品
```
url:http://域名/api/shop/product/publish_product
请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填


json参数:
{
	"product_attr":[{"颜色":"绿色"},{"颜色":"黑色"},{"容量":"32G"},{"容量":"64G"},{"容量":"128G"},{"尺寸":"超大"},{"尺寸":"超小"}],  //商品属性  数组格式  内部为对象
	
	"product_name":"超级无敌大飞车玩具赛车黄色1",  //商品名称
	"product_sku_no":100023,  //商品编号
	"product_keywords":["玩具","赛车"],  //商品关键词  数组
	"product_images":[{"main":"mall/users/AF_CN_7a49b34079/product/155047099099801852.jpeg"},{"1":"mall/users/AF_CN_7a49b34079/product/155047099099801852.jpeg"},{"2":"mall/users/AF_CN_7a49b34079/product/155047099099801852.jpeg"},{"3":"mall/users/AF_CN_7a49b34079/product/155047099099801852.jpeg"},{"4":"mall/users/AF_CN_7a49b34079/product/155047099099801852.jpeg"}],  //商品图片 数组 内部为文件path
	"product_price":[{"min_order":"10","order_price":"800","unit":"Pieces"},{"min_order":"5","order_price":"2","unit":"Pieces"},{"min_order":"1","order_price":"1","unit":"Pieces"}],     //价格 数组  此为阶梯价 基本价格式 [{"min_order":"50","min_order_price":"100","max_order_price":"200","unit":"Pieces"}]
	"product_price_type":"ladder", //价格类型 必填  ladder 或 base
	"product_details":"这里是描述描述再秒睡<div>大萨达撒多撒大萨达sad撒<div/>",  //商品详情 可以是 html
	"product_publishing_time":"2019-03-14 11:00:00",  //定时发布时间 不定时发布 传 null
	"product_categories_id":1,  //分类id
	"product_group_id":null, //分组id 不设置传null 
	"product_put_warehouse":false  //是否放入仓库  布尔值
}

返回:
{
    "code": 200,
    "message": "创建商品成功!",
    "data": []
}
```

42.获取单个商品的详情

```
url:http://域名/api/shop/product/get_product_detail
请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

json参数:
{
"product_id":29
}

返回:
{
    "code": 200,
    "message": "获取商品详情成功!",
    "data": {
        "product_info": {
            "id": 27,
            "company_id": "10",
            "product_origin_id": "PD_CN_a49b34079_524b40b0",
            "product_categories_id": "1",
            "product_name": "超级无敌大飞车玩具13赛2221",
            "product_sku_no": "100023",
            "product_keywords": [
                "玩具",
                "赛车"
            ],
            "product_images": [
                {
                    "main": "mall/users/AF_CN_7a49b34079/product/155047099099801852.jpeg"
                },
                {
                    "1": "http://www.xx.com/2.jpg"
                },
                {
                    "2": "http://www.xx.com/2.jpg"
                },
                {
                    "3": "http://www.xx.com/2.jpg"
                },
                {
                    "4": "http://www.xx.com/2.jpg"
                }
            ],
            "product_status": 2,
            "product_audit_status": 0,
            "product_publishing_time": "2019-03-14 11:00:00",
            "product_price_id": 48,
            "product_details": "这里是描述描述再秒睡<div>大萨达撒多撒大萨达sad撒<div/>",
            "created_at": "2019-02-19 09:47:31",
            "updated_at": "2019-02-19 09:47:31",
            "deleted_at": null,
            "product_attr_id": 49,
            "products_attr": {
                "id": 49,
                "attr_specs": [
                    {
                        "颜色": "绿色"
                    },
                    {
                        "颜色": "黑色"
                    },
                    {
                        "容量": "321G"
                    },
                    {
                        "容量": "64G"
                    },
                    {
                        "容量": "128G"
                    },
                    {
                        "尺寸": "超大"
                    },
                    {
                        "尺寸": "超小"
                    }
                ],
                "created_at": "2019-02-19 09:47:31",
                "updated_at": "2019-02-19 09:47:31",
                "deleted_at": null
            },
            "products_price": {
                "id": 48,
                "price_type": "ladder",
                "base_price": null,
                "ladder_price": [
                    {
                        "unit": "Pieces",
                        "min_order": "10",
                        "order_price": "800"
                    },
                    {
                        "unit": "Pieces",
                        "min_order": "5",
                        "order_price": "2"
                    },
                    {
                        "unit": "Pieces",
                        "min_order": "1",
                        "order_price": "1"
                    }
                ],
                "currency": "ksh",
                "created_at": "2019-02-19 09:47:31",
                "updated_at": "2019-02-19 09:47:31",
                "deleted_at": null
            }
        },
        "product_attr": {
            "id": 49,
            "attr_specs": [
                {
                    "颜色": "绿色"
                },
                {
                    "颜色": "黑色"
                },
                {
                    "容量": "321G"
                },
                {
                    "容量": "64G"
                },
                {
                    "容量": "128G"
                },
                {
                    "尺寸": "超大"
                },
                {
                    "尺寸": "超小"
                }
            ],
            "created_at": "2019-02-19 09:47:31",
            "updated_at": "2019-02-19 09:47:31",
            "deleted_at": null
        },
        "product_price": {
            "id": 48,
            "price_type": "ladder",
            "base_price": null,
            "ladder_price": [
                {
                    "unit": "Pieces",
                    "min_order": "10",
                    "order_price": "800"
                },
                {
                    "unit": "Pieces",
                    "min_order": "5",
                    "order_price": "2"
                },
                {
                    "unit": "Pieces",
                    "min_order": "1",
                    "order_price": "1"
                }
            ],
            "currency": "ksh",
            "created_at": "2019-02-19 09:47:31",
            "updated_at": "2019-02-19 09:47:31",
            "deleted_at": null
        }
    }
}
```

43.删除商品
```
url:http://域名/api/shop/product/delete_product
请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

json参数:
{
"product_id_list":[28,30]  //必填 数组格式 商品id的列表
}

返回:
{
    "code": 200,
    "message": "删除商品成功!",
    "data": []
}
```

44.编辑商品

```
url:http://域名/api/shop/product/edit_product
请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

json参数:  注意以下参数 除product_id 必填外  其他参数非必填 不更新传null或者不传参数 即可！
{
"product_id":28,
"product_images":[{"main": "mall/users/AF_CN_7a49b34079/product/xxxx.jpeg"}, {"1": "http://www.xx.com/xxxx.jpg"}, {"2": "http://www.xx.com/2.jpg"}, {"3": "http://www.xx.com/2.jpg"}, {"4": "http://www.xx.com/2.jpg"}],
"product_name":"超级无敌大飞车玩具133赛222d331",
"product_sku_no":"2323dsds",
"product_keywords":["你好","很好"],
"product_attr":[{"颜色":"小色"},{"颜色":"大色"},{"容量":"32222221G"},{"容量":"64G"},{"容量":"128G"},{"尺寸":"黑大"},{"尺寸":"白小"}],
"product_price":[{"unit": "Pieces", "min_order": "150", "max_order_price": "2010", "min_order_price": "100"}],
"product_price_type":"base",
"product_details":"fffffffffffffffffffffffffff",
"product_publishing_time":"2019-03-14 11:00:00",
"product_categories_id":1,
"product_group_id":15,
"product_put_warehouse":1
}

返回:
{
    "code": 200,
    "message": "编辑更新商品成功!",
    "data": []
}
```

45.上传幻灯图片

```
url:http://域名/api/shop/upload_slide
请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

json参数:    base64图片
{ 
"slide_img_base64":"data:image/png;base64,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"
}

返回:
{
    "code": 200,
    "message": "上传成功!",
    "data": {
        "img_path": "mall/users/AF_CN_7a49b34079/shop/15507166726985401.png",
        "img_url": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_7a49b34079/shop/15507166726985401.png"
    }
}
```

46.设置幻灯图片

```
url:http://域名/api/shop/set_slides
请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

json参数: 
{
"slides_list":[{"sort":1,"url_path":"mall/djwkw/dsd/sbs12.jpg","url_jump":"http://www.qq.com"},{"sort":2,"url_path":"mall/djwkw/dsd/d3335.jpg","url_jump":"http://www.qq.com"}]   //数组对象  sort为排序 url_path 为图片路径   url_jump 没有就传null!
}
返回:
{
    "code": 200,
    "message": "设置幻灯图片成功!",
    "data": []
}
```


47.获取店铺banner图片


```
url:http://域名/api/shop/get_shop_banner
请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无参数

返回:
{
    "code": 200,
    "message": "设置幻灯图片成功!",
    "data": []
}
```

48.设置店铺banner图片
```
url:http://域名/api/shop/set_shop_banner
请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

json参数

{
"banner_img_base64":"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAkCAYAAABCKP5eAAAV1ElEQVR4nJ2baZBcV3XHf2/p93qZTTMaWftiWbLlRd5NBRMTLIPLYTEmhJRTQFVIzJIiBgyEkA+QkARjoJwUJoSlUiEuQrAJDgXBS0EwdgWMMbLxbsmSLFmyNNpGI830+pabD93n9nm3ewzJreqa6dd3O9v/LPc+7+DBg4ZeM6b7r+d5lEolqtUqpVKJIAjwPA/dz/M8+8wYQ5Zl5Hk+8FuSJDQaDer1Op1Oh3K5zMTEBOVymSAIaLVaNJtNkiQhTVOSJCHPc3zft/MYY+wnTVPq9TpJkhCGIVEUEQSB3Uee5wAEQUAQBJYml7ZSqUSapmRZVqBDxsv/8pvQJvuS+eQ5YHkgY+RvEAT4vo/v++R5TpZl9rvQJU1o1rRLX/27rCU8KJfLlqfCpzRNCVHN932CIKBUKhGGYYFxWnBagLKoVgL9uxCRZRlZltnFkyQhyzL7Vz4yxhWKXieOY8IwtPt1GSJ71Qx0hSh70XTIGvJcK4hmsB4nzzWtei1XaCJsPa8WsvSTeUWhXJ5oupMksX20QQZB0Bew53mEYUipVCKOY4IgIM9z0jS1BAhzgiAgiiK7+GJNFo3jeMC60zQlz3M6nY61JP27tiRXkcrlcmEdLVBtUS7T9HPdT57pjxawfNfj9VgtWC1ceaYtVq+nx+r9uIbiCl3LK89zi3pZlhGGYYH3oTHGwlkURdZ6haA0Tel0OiRJQqfTodFoUC6XmZ6eplqtFogW2HDhMQgCqtUqcRzbZ+12m3a7baHZZZALzcIMl1BXSNCHTYE3eabn0KgjDFrMklyFERiW/lo5taVrBXAh2RWaK1x3D2IogqphGFIul0mShHa7bRVfBGwh2kpaCbXdbtsFOp0OzWbTWrNmRJ7nhe/aD4ugxRrF90lfEa4IQca6FqItwvVtMrfuP8wyXWuQ52mWcSRNaKQZq4IAz2HwMKt0m4tg2tpdGlxU0ki1GF1JJ2f3swc5NrNAq5FRrZVZv2ma8y/dQBRFhGFo3ZXAs44FQk2ACEwWLZVK1vTF95VKJRvYuEIWrRFhymZlvHyXcdJX+2ltLQJDQMHH3/rHP+Yj/3LVyzJeLDXPc5rG0DGGLM8JgarvU/I8cmN4qdMBYGkQUFM06YBLC9FVIM/zyLyctpdQzWMAWnT47Pi3ORSc4PL22byjsa0wVuYT6HZjGmMMx2bmeeDunTz3q4Nk2SB9E5M1/uSm17H10g3WcLSyBEHQtWARjESuWW6Io4hyObaWJYSIjw6CwFq8hoRGo8HCwgKe51EulxkdHcX3fTqdDr7vU6lULOS3Wi2SJCkEStritSVEUUQURWRZxi3vvI+Pfv21BWK1oHVccCRNOZwmpI4CeMCSIGBVKbLP2h6MDPGzwhfdjDEc8I7ynZGfsj1+nn3hUYxnCE3A5mQVr2mez/2VJ8i8nKX5WMFiRZE1/Eq8I2s+8sAe7rnzSfJ8ULDS5mbr3PqJ7/K+j/8uF79yYx+SVWYRRRHezMyM0f7qiaf38rNHnmPNqmlOX7+CtaunmVrSFZT46CzL6HQ6VpASNM3NzXHy5Ena7TZhGDI2NkalUrEWLUJqNps0m03mFxb4r+2P8fOdzzMzN0cYBLzyzM3c8NptFhlkrKyrgz4tiAK8ATsadRZ6ygkQeR6x55ObrkXnvWedHvOXhSVWR5FFFu33NXrkec4/V+/j9pEfkXldiwlNwLip0fBaNL1OYX9ndlbz1WM3DgRfslcJVkXAjzywh+9/81eLCtZtYSngk1/4A6aXj1mXF4ahzTRC0R7xmY1mB2MM+/YfZt/+wwCU44h1a5ax8fRVnLFhNbVqRL1et5Ys8CvBVZZltNttK6CxsTHiOLYaHIYh+D5/+53/ZOfBQ3aznTTlVLM5ELBo364hdFi0GYYhz9f7wh0JAtbFZaoqIs7ynJk0YSZJ7NpNBceuz9TCuWX0Tr5ffRiAM5KVvLt+Db8TXshoeYRGo8HzrRf5YfwoXx/rKsDh4EQBBYbBsdB38kSTe+58YogQfc69eB3lcsT2n+4iSfqKmyYZ3/zyg3zoU2/C932SJKHZbPajaA0VURRx9bZLufKKC9l34Agv7Jthz95DzJ44xY5dB9ix6wDwMONjNdaunuaVl53NiIIcKY6IUKrVKpVKxcK59u/3bn/UCve8dWu59tJLmKjV8B2/6gYsrkC1MpRKJZrGcKzTDRJrQcCW2ogNnkQxAt9nVRSTG8ORHiI08j7TJL7QuaYxhnvKj1jhXtY5k8+fuoHYjwhyn3a7TZZlrMqX8o6Fbdxb285L4XHmgjodL6VMNDQD0HQ99N+7SNO+HwWojcZ8+O/eyNoNyymVSjz35Et85s/vRHudZx8/wMEX51izYcrGTZINhaJdIuAoiojjmHPO2sA5Z23A8zzm5ubZuXs/Tz27l337D3PyVJ0nn6lz9ZWXFaxIcF/n0xLhuSnPwzt2AjBRq/Kx664l6vlyN43QFqSbC3kCpYcXFmyftZWqVRg3igZYUYo4nqZkQAakxhAukupkJuMrtbsBiE2Jv66/k9jvwqsUbmQfxhiWZ0t4KTwOwLH4FOuy04B+8OcGhp7nsfuZIwN0XnXtVtZuWE7Ucx+bzl7OZVds5uEHdhb6/fwnOzh986utctpCiQRRpVJpICeT/8fGaoyN1jhybM4+v3DrJiqV2IbpEi1nWUYURVQqlcKcmrgkSZjtCWL9smVU4tiuJYIS69ECF0V0Ba6FfbJnvT7doEn2JH5VzxGFIZO9aB+gRbGsqJXisWg3R4OTAGzrXMgUY9Z3usrg+z7Ls0n7/Uh0sjDvMDqMgeOH+8op7byLTrdW2Wg02fH0foLQH+j3xCMvdNOqXr1CCkih+E9dtdJBRZqm/PD+X/Lw9ue6ihAGXL3tUs4/d6NlnmxeAgaBB5lXFxLSNO3WnntrhSrAcKNnLdyXy3V16tXqKWzkFataurihU7KJMORozxc3soyxHj/c9nSwr8/0dL2dT5ivUxSAFXlfwIf82QH0kO/F2GIwat676whPPfoiO586wO7nDtFupQN9AEbHKwUEyfNcgt2wkJfJ4r7vM3dygTvu+jGHDs8CsHRqnLdd9xomJ0Zs8UOXLQXipQkjxT/tO3KE933pK4WN/XL3Hn7/c7cCsHLJEj77jj8s/C6MyFRE7AZZuuVW8Mbm2ZomnaoAVL2+NTSylCwLBipNnudx2D9h+00wamnf/cW+INe8e8Za9QplwTP+iYGYQruBrpv08H1vQMjf+NL9AzS6zfPgTde/wpZ85W+vdBlaQnTR4ulnX+B79/yMdqer3eefu5HXX/1bRKXQVqFEgxdL1kWrBcYr5QqVngK0kg7GgO95lHrWHpXCgrUu5ofdQxDdP8Ajx5CaYv0Y+gqsn/nGEND1wY3e4YesIbFEGIbEfl9x617TRr7r33fUrrP3n5bbPltZxbe5FoCv3PSZwmmULhIJkhhjmJyucWwITA9rE5M1Tj9rGWdsWcFZW1excu2UPZlrNpuWZ6ExhlarpRaChx7ZwRPPvAB0Ifma117G1nM2Ali4FT8pQZTbNAHQtboVSyb4wac+SRRFXH/zLew/eoxLztjIR659Y0FQLgTLfFrg7u/Wr/oeSW5Iuw/xlLWLuxCFtkduPQG3e3MJTVL/jeOYdfkKu9Zz/n6uMZfY9Edgce17DltaZ/xZrpv8FADfvvkODjr8WX3DoQEalq8eHypgz4PTVo2zbtNSNp61nLPOW8OyFROFwo5WHnGPQFfAp06d6p7ZNjo8tH0XcycbAEwvneAtb3gVE+M1W5+WiaSwHSzis4RQYaI4fTnDdJvOeYehgRbwsFKiEFrzA+q9501jqKp5RMBSe5fqD0EvuASyIGCkd1qV5zlRFFGtVvltcwE3N/4NgPujX3Gjdy2hFxT2oatgy/IJAuOTeTnv/dgN3Hvq0wWEPPC1lQM8uNxfy1N8ceD5X3z+OsYnY1vAKJfLtqIIcGquTqUWUyp1q361Wq3vg8USX3xplu1P7CXLups984xVXPXqC6lWK0NLdZ1OhzzPCyccbtNHjjqFcgMmKYgM86nS3OKDNBGW/FZTe53ttKn0ypGiIFIjl4JLEARkab/g0cgyRtTxnuzrIn8zG72V7DYHOe7P8++Vn/D2xpUF36r96n7/KB7dPc9685xgnglvxFr7uvcescoqvGo3M97D+wdon/0WxO86YCuGfd4Z7rvrUe66/Wds2HwaN/3Nm4nisFBiDcMw5OkdB/jFY3sACMOAV1y0kc0bV5FlqYU0N0jQTHu5lmUZrVbLHlbY+rZCp2EQ79aXh/2m4UmIGg8CfCAHZrOMFSUIvMFDfCn0t+nBea+1KdImx3EAHzC/x43cBsBXa3ezIp9kW+uCgYBsX3CYD418Gb8nYOMZPl39Fm/rXMHF6SYCgkJKKhW4kekRflC5j188+PwAP4YJ/rabPwLXA9fDU+zlXTw80Cf0fZ/dew/bB6UwYObwHIHvc/qGldbibBWoh/HlcvllD/yF8a1Wi4WFhcJFgkSVCMUCdaqhq0c6B9bfpZ/Ari54LA1LHEkTMuBQmrK2dw6tFRO6ynewV8Hy6OpcmyJaSAaQpimXZ1t4S/wq7or/h8zL+cTY7dwb/5KrGhewPJ9kzq/zSHknP4gfJsfwjwvv55bKnewJD/GT6HEeKe3gwflb7d4/uOqWQcZ9Yig7uY2PDTz7s48PGQ9suWnBnhV4WZaZRx/fya49L/HCvhla7WKxfOnUGCuWjXPa9DhLp0aplMtUq1XGx8cLAdbQlKXne1utls2PJW169xe/xEvHZ7ls0xl8/K1vKdRk3UKLK3id6riFBs/zyIBnWk0ksVpWKrEyignop26nsoyZLKVpDFNBQMcY5vOc2PO5YGxswO/raPer1bu5vfIjLh9fO1wav2H73N6bgG5QV6vVbFxz712P8q2vPfh/missBbzrg1ey5cKVPPf3o/3nnudx4dZNnLtlPe12mxf2HeT53fs5cmyeY7PzHDt+imPHT/Hks/sJfJ9rtp3P2jWVwuTD0iPxAXEc2zKbBFl5nluI1v3dlEcLbVgUPazc53keIXB6FLOr0wXcI0nC0SSh3EOBtjEY4I5zvzaUWbf/Bgy9nLWcNrOG7dHzzPgniCmxLjuNSzubeVv7CkbyyqJjLYKQ8cSJbr+rzgxtgel1b76ARr3F9775i1+7D8+Dcy9ey5vffhnTK8Zot9usfc9hm72EAJ1Oh3q9TqvVYrQWcfbmVWzZ1E2ZZo7OMXN4jqPHF1hotFmxfNrCs96s3nySJCRJYmFZhChRqy5aAIVKFxSv1QDoYowucvzlptt+LQNern3guT9leamEBxxKOsz0qmubopgRdTlOuyhX0dwmCFFP64XSqD64eOpkzfa/YKptLVcCwDRNec0btrBy/Sg/+u6TvLDjaOHQ3/Ngatko689cwoZzJli7YRoTtJif9wplXoBQDunl6qq+4WiMYfn0OKtXTHX9pAFjiqVHfWgvJUt9GmNM93pOs9m0/gzAYFjzhYwZdvJRbv1/CeiWPR8sMFb7a90WsoyFNCUxhtCDih8w4vt4IZg8xwBl+gJrG8OoE7xJc4OjYRmG2w/gmfk+bJ49Oq/GFm+FAtaNLVtV4603XESeGU7OtimFEbWRKkuWVmm26hw/ftzyVWIZrVDGGMJWq4V8JJgQQQP2zm2pVLJBjQj37fFHIWKwlXofadXeR7Xgr2D/jQGXbDydm974+gEL1cGUm4Zp1HDdw7BCSNXzqKjc2xgDpnsuLHOU/f48TSXQxdbSza0xi3Afn+3f/jx3vK6CPCxd4sIkBdIXDkQecRyzbuM4tVrN3iX32p7123LV2T3YyfO8G0ULJLZaLdrtNmmactsV/zGUGN3uyP+hcJdZChsS/Agky81JLbwP/+s3gBMYM/wGpdZoXeZzUzbd9EmNe6ldN7FKndrExtj0qmnygaje9fkyXsOw7/s8dqyv8VuXNO16UIwpRLgjIyPEvdM0QTq54iTurVqt2uKF1NcnJiaYnJy0Rqf5LvMDhCdPnrS5nhQvfN/npoeuJwxDpqammJycpFKpFA4SujvFpji6UuUigevDilbRF86wMqUuiLjPNExqIbg3NPU414/q/2PPo2mMteBh+fewiP7JuT48XTDVtsohW3br6BKbyNsIYRjaVE+afJeKVZ7n9h7b6Ogo1Wq1YPmNRmPg0iJAODs7qzbUlb7AchzHjI2NUavVhua8IpAkSWi1Wva4UbRJBOxWoTzPw7Wrl4uQXSG7AtbW7Va63L269WNd9al4Pk2TkQGJMURKwC70a5963kTD9slzBpis6RNfqV810dUsucMmBwYiREFB6acvUghvhNc6qAtbrVaBEWEYUq1WGRkZoVarUa1WF40aJciS4MklSG9AMykIAm79o3cWoFZDpp5/2Ef6aMYs1l7uaNFdo+xpP5wRmP61nTzPC5Z63kRDIU4/qHFdjKu0blSuLyIIHeVymaVLl9oqogSvtVqtizS9iqBGSz2H3MoxxhBmWVa4ClupVKzVVir9OrTAnnumqm8PaAtzidVCHkb0sIMDPXax/Fh+0wJz/9dj9P41TAMFAXeMAQ+bpwKcM7Zg55Nlhim/m+7ppi1ZN+3CJCORywRyDdYt8khF0PM8W3EUhZD6fCgWK9FcrVZjdHS0cFohlqpPgkT75LUWHUS5zfV9LmGaOGGMzuXcsYutMeyvzCdo4ubgej9Vz2NTKWLP/CiHgEN0hSrHo57nF1yZizbD9uJW+lxlF4gW/krVTKxSZKBRS3gvKapOkfSZdxAEhOPj44X3huRwXr+JIAtIMKXLdjqg0RvXG5L+AjVaaBqudGSqT5jEErT16b4uA4fB+TAGa+R4dmHMPpfot7t/b4C50L/W5KKKq2CCeno9rdRCl7zOKlmMvEimT+t08Cp9ZP9yd1zfYPU8j3BqasoyTr/SCRTObYUAudQlTfveYUzUxOpAyLUw9z1dd5x8ZP7FAirXkjSsaaZ6XrGidPbovKqgDb4kNixg0p9hvw/jBRTPyYdlAmKFAtNA4RqODmKl6bvpQrsxhnB0dNRewRGoaDQaVCoV21nyL+mnLVgzWTNe3+8a9l6SfBcC3HeENYNezs+5FqmtRD/TAnj61AjQD5S6n0FIXcwlCNy7+3IVV1u4jJP5tCWLghvTf01Huyn9BqYgodQYxHK1rPT+Q81ICdFFSJKLDctrZcxikbJrha6W676izfrVFIEaPZ8wRPy9KI8+xNd1bD1eW8u54/Ues4tI4B5JDrM+N3CSfWh6tPtw3YgIzoVTsUjpqy8xSJyjXYXIQvtoz/NYWFhgfn6+f+Knc1+JmkVj5PUTXSVxDwW0ELXmaMG7FqT7umggUK2tSVu9K2Ad6AyDzGHBj4Z7/ZurnMOUUgvSzRRci11sLl0vdvdQr9fJ8/6bCfp1UFlP4FoHjhKszc3NMTMzw+TkJOVymf8FHZ86pZ9aYBwAAAAASUVORK5CYII="
}
返回:
{
    "code": 200,
    "message": "更新成功!",
    "data": {
        "img_path": "mall/users/AF_CN_7a49b34079/shop/155071784499763751.png",
        "img_url": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/users/AF_CN_7a49b34079/shop/155071784499763751.png"
    }
}
```

49.获取店铺幻灯图片列表

```
url:http://域名/api/shop/get_slides_list
请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无参数

返回:
{
    "code": 200,
    "message": "获取幻灯片列表成功!",
    "data": [
        {
            "sort": 1,
            "url_path": "mall/djwkw/dsd/sbs12.jpg",
            "url": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/djwkw/dsd/sbs12.jpg"
        },
        {
            "sort": 2,
            "url_path": "mall/djwkw/dsd/d3335.jpg",
            "url": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/djwkw/dsd/d3335.jpg"
        },
        {
            "sort": 3,
            "url_path": "mall/djwkw/dsd/sbff",
            "url": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/djwkw/dsd/sbff"
        },
        {
            "sort": 4,
            "url_path": "mall/djwkw/dsd/sbxx",
            "url": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/djwkw/dsd/sbxx"
        },
        {
            "sort": 5,
            "url_path": "mall/djwkw/dsd/d3335.jpg",
            "url": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall/djwkw/dsd/d3335.jpg"
        }
    ]
}
```


50.删除店铺banner图片

```
url:http://域名/api/shop/delete_shop_banner
请求方法:post
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无参数

返回:
{
    "code": 200,
    "message": "删除banner成功!",
    "data": []
}
```


51.获取系统配置
```
url:http://域名/api/get_sys_config
请求方法:get
请求头参数:"Accept",值:"application/json"    //必填 否则拿不到
请求头参数:"Authorization",值:"Bearer空格+token" //必填

无参数

返回:
{
    "code": 200,
    "message": "成功!",
    "data": {
        "oss_url_prefix": "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/"
    }
}
```