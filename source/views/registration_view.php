<!doctype html>
<html lang="ru" data-placeholder-focus="false">
<head>

    <title>Регистрация | вход</title>
    <link rel="shortcut icon" href="/favicon.ico" sizes="16x16" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <!-- корректно на мобильных устройствах -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="title" content="Регистрация | вход">
    <meta name="author" content="edzi">
    <meta name="Copyright" content="edzi 2018. All Rights Reserved.">
    <meta name="robots" content="noindex, nofollow">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="apple-touch-icon" href="https://s3-eu-west-1.amazonaws.com/typeform-media-static/typeform-touch-icon.png"/>
    <link rel="apple-touch-icon-precomposed" href="https://s3-eu-west-1.amazonaws.com/typeform-media-static/typeform-touch-icon.png"/>

    <link rel="stylesheet" href="https://font.typeform.com/dist/font.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="https://font.typeform.com/dist/gt-america.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/style_new.css">

</head>

<body>
<div id="layout-wrapper" class="layout-white">
    <div id="layout-aux" class="layout-white"></div>
    <div id="layout">
        <div id="center-aux" class="signup">
            <div class="header">
                Уже зарегестрированы? <a href="/auth/login/" class="signup-login-button">Войти в личный кабинет</a>
            </div>

            <div id="wrapper">

                <div class="signup__wrapper">

                    <form id="signup"
                          action="/auth/registration"
                          method="POST"
                          novalidate
                          autocomplete="off"
                    >
                        <input type="hidden" value="" name="mobileUserId">
                        <input type="hidden" value="" name="workspace_id">

                        <div class="hidden" id="custom"></div>
                        <span class='error-description'></span>

                        <div class="input-wrapper">
                            <label for="signup_owner_alias">
                                <span class="input-text">Имя</span>
                            </label>
                            <input type="text" id="signup_owner_alias" name="signup[owner][alias]" required="required" placeholder="Alexander Platonov" autofocus="" />
                        </div>

                        <div class="input-wrapper email-field">
                            <label for="signup_owner_email">
                                <span class="input-text">Email</span>
                            </label>
                            <input type="email" id="signup_owner_email" name="signup[owner][email]" required="required" placeholder="alexander@platonov.ru"  />
                        </div>

                        <div class="input-wrapper">
                            <label for="signup_owner_password">
                                <span class="input-text">Пароль</span>
                            </label>
                            <div class="password-wrapper">
                                <input type="password" id="signup_owner_password" name="signup[owner][password]" required="required" placeholder="Никому не скажу" />
                            </div>
                        </div>

                        <button id="btnsubmit"
                                class="admin-button v2-black"
                                type="submit">
                            <div class="label">Создать аккаунт</div>
                            <div class="spinner"></div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
