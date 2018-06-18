<label><?php if (!empty($message)) echo $message;?></label>
<form action="/auth/login" method="post">
    Почтовый ящик: <input type="text" name="mail" /><br />
    Пароль: <input type="password" name="password" /><br />
    Запомнить <input id="remember" type="checkbox" name="remember" checked="1"/><br />
    <input type="submit" value="Войти" name="log_in" />
</form>