<label><?php if (!empty($message)) echo $message;?></label>
<form method="post" action="/auth/registration">
    Email: <input id="mail" type="text" name="mail" <?php if (!empty($mail)) echo "value='$mail'";?>/><br />
<!--    Логин: <p></p><input id="login" type="text" name="login" --><?php //if (!empty($login)) echo "value='$login'";?><!--/><br />-->
    Пароль: <input id="password" type="password" name="password" <?php if (!empty($password)) echo "value='$password'";?>/><br />
    Подтверждение: <input id="re_password" type="password" name="password2" <?php if (!empty($password2)) echo "value='$password2'";?>/><br />
    <input type="submit" name="GO" value="Регистрация">
</form>




