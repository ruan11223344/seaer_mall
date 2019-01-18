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





