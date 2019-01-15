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

注意:只有请求头参数,无其他参数。
```


  
 

