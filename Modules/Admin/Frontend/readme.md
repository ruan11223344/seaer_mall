## 接口说明 域名 admin.seaer.com

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
请求方法:get
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
