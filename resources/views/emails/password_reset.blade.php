<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>

    <style>
        * {
            padding: 0px;
            margin: 0px;
            letter-spacing: 0px;
            text-decoration: none;
            line-height: 1;
            font-family: ArialMT;
            font-weight: normal;
            font-stretch: normal;
        }
        .header-logo {
            width: 181px;
            height: 53px;
            background-color: azure;
        }

        #main {
            width: 765px;
            height: 447px;
            background-color: #ffffff;
            border: solid 1px #dddddd;
            margin-top: 14px;
        }
        .main-hgroup {
            margin-top: 42px;
            margin-left: 55px;
        }
        .main-title {
            font-size: 16px;
            line-height: 18.5px;
            letter-spacing: 0px;
            color: #333333;
        }
        .main-title + h3 {
            font-size: 16px;
            color: #999999;
            margin-top: 5px;
        }
        .main-article {
            margin: 31px 18px 0px 48px;
        }
        .main-article > p:first-child {
            font-size: 14px;
            color: #666666;
            text-indent: 2em;
            line-height: 2;
        }
        .main-article > a:nth-child(2) {
            font-size: 14px;
            line-height: 2;
            color: #f0883a;
            word-break:break-all;
            text-indent: 2em;
        }
        .main-article > p:last-child {
            font-size: 14px;
            color: #666666;
            margin-top: 10px;
            margin-bottom: 50px;
        }
        .main-btn {
            width: 110px;
            height: 40px;
            background-color: #f0883a;
            font-family: ArialMT;
            font-size: 18px;
            color: #ffffff;
            cursor: pointer;
            border: none;
            margin: 0px auto;
            display: block;
            margin-top: 40px;
        }

        footer {
            padding-left: 45px;
        }
        footer > div {
            font-size: 14px;
            color: #999999;
            line-height: 1.5;
        }
    </style>

</head>
<body>
<header>
    <div class="header-logo">
        <img src="{{ $message->embed($logo_url) }}" alt="">
    </div>
</header>
<section id="main">
    <hgroup class="main-hgroup">
        <h1 class="main-title">Please continue to modify your password</h1>
        <h3>(Valid for 24 hours)</h3>
    </hgroup>
    <a href="{{ $reset_password_url }}">
        <button type="button" class="main-btn">
            Complete
        </button>
    </a>
    <article class="main-article">
        <p class="">You can click the button above or click the link below to complete the registration or copy the following linkin to the address bar of your browser to complete the registration.</p>
        <a href="{{ $reset_password_url }}">{{ $reset_password_url }}</a>
        <p>This is system email,please don't reply to it.</p>
    </article>
    <footer>
        <div>Best regards</div>
        <div>Afriby.com</div>
    </footer>
</section>
</body>
</html>