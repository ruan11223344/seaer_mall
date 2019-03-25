<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            font-weight: normal;
            font-stretch: normal;
            font-family: ArialMT;
            line-height: 1;
        }
        .main {
            width: 100%;
            height: 100vh;
            background-color: #f5f5f9;
            display: flex;
        }
        .block {
            margin: 50px auto;
        }
        .header {
            width: 181px;
	        height: 53px;
        }
        .header > img {
            width: 100%;
            height: 100%;
            display: block;
        }
        .box {
            width: 765px;
            height: auto;
            background-color: #ffffff;
            border: solid 1px #dddddd;
            margin-top: 15px;
            padding: 0px 40px;
            padding-bottom: 45px;
            box-sizing: border-box;
        }
        .title {
            font-size: 16px;
            color: #333333;
            font-size: 16px;
            margin-top: 47px;
            margin-bottom: 26px;
            text-align: center;
        }
        .box > p {
            margin: 10px 0px;
            font-size: 16px;
            color: #666666;
            line-height: 1.4;
        }

        .box > p > span {
            color: #f0883a;
        }
        
        .footer {
            margin-top: 25px;
            font-size: 14px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="block">
            <div class="header">
                <img src="{{ $message->embed($logo_url) }}" alt="">
            </div>
            <div class="box">
                <h1 class="title">Your Password Changed</h1>
                <p>Dear <span>{{ $user_full_name }}</span></p>
                <p>This email is sent by system automatically, please don't reply to it. For any questions, If this not your own actions , Please feel free to <span>Contact Us</span>.</p>
                <div class="footer">
                    Best regards
                    <br>
                    <br>
                    Afriby.com
                </div>
            </div>
        </div>
    </div>
</body>
</html>