<?php
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 22.05.2018
 * Time: 11:35
 */
$phrases = array();

$phrases['user_blocked'] = "Ваш аккаунт заблокирован.";
$phrases['user_verify_failed'] = "Защитный код код недействителен.";

$phrases['email_password_invalid'] = "Недопустимые E-Mail или пароль.";
$phrases['email_password_incorrect'] = "Пользователь с указанным E-Mail'ом не обнаружен в системе или пароль не подходит.";
$phrases['remember_me_invalid'] = 'Недопустимое значение поля "запомнить пользователя".';

$phrases['password_short'] = "Пароль слишком короткий.";
$phrases['password_weak'] = "Password is too weak.";
$phrases['password_nomatch'] = "Пароли не совпадают.";
$phrases['password_changed'] = "Пароль успешно изменен.";
$phrases['password_incorrect'] = "Текущий пароль указан неверно.";
$phrases['password_notvalid'] = "Недопустимый пароль.";

$phrases['newpassword_short'] = "Новый пароль слишком короткий.";
$phrases['newpassword_long'] = "Новый пароль слишком длинный.";
$phrases['newpassword_invalid'] = "Новый пароль должен содержать хотя бы одну цифру, хотя бы одну строчную букву и хотя бы одну прописную..";
$phrases['newpassword_nomatch'] = "Новые пароли не совпадают.";
$phrases['newpassword_match'] = "Новый пароль такой же, как старый.";

$phrases['email_short'] = "Адрес E-Mail слишком короткий.";
$phrases['email_long'] = "Адрес E-Mail слишком длинный";
$phrases['email_invalid'] = "Недопустимый E-Mail.";
$phrases['email_incorrect'] = "E-Mail неверен.";
$phrases['email_banned'] = "Этот E-Mail запрещен.";
$phrases['email_changed'] = "E-Mail изменен успешно.";
$phrases['email_taken'] = "Этот E-Mail уже используется!.";

$phrases['newemail_match'] = "Новый E-Mail совпадает со старым.";

$phrases['account_inactive'] = "Аккаунт еще не активирован.";
$phrases['account_activated'] = "Аккаунт активирован.";

$phrases['logged_in'] = "Вы вошли в систему.";
$phrases['logged_out'] = "Вы вышли из системы.";

$phrases['system_error'] = "Произошла системная ошибка (проблема с печеньками, сессией или базой данных). Попробуйте еще разок.";

$phrases['register_success'] = "Учётная запись создана. На вашу почту отправлены инструкции по активации.";
$phrases['register_success_emailmessage_suppressed'] = "Учётная запись создана.";

$phrases['resetkey_invalid'] = "Ключ сброса пароля неправильного формата.";
$phrases['resetkey_incorrect'] = "Ключ сброса пароля неверный.";
$phrases['resetkey_expired'] = "Срок действия ключа сброса пароля истёк!";

$phrases['activationkey_invalid'] = "Недопустимый ключ акцивации учётной записи.";
$phrases['activationkey_incorrect'] = "Неверный ключ акцивации учётной записи.";
$phrases['activationkey_expired'] = "Срок действия ключа активации истёк!";

$phrases['reset_requested'] = "Запрос на сброс пароля выслан по почте.";
$phrases['reset_requested_emailmessage_suppressed'] = "Запрос сброса пароля создан.";
$phrases['reset_exists'] = "Сброс пароля уже запрошен.";
$phrases['password_reset'] = "Пароль сброшен успешно.";

$phrases['already_activated'] = "Учетная запись уже активирована.";
$phrases['activation_sent'] = "Сообщение с инструкциями по активации учетной записи выслано.";
$phrases['activation_exists'] = "Мы уже высылали вам сообщение с инструкциями по активации учетной записи.";

$phrases['email_activation_subject'] = "%s - Активировать учётную запись";
$phrases['email_activation_body'] = 'Здравствуйте,<br/><br/>для входа в систему вам нужно сначала активировать ваш аккаунт. Перейдите пожалуйста по этой ссылке: <strong><a href="%1$s/%2$s">%1$s/%2$s</a></strong><br/><br/> и введите следующий ключ активации: <strong>%3$s</strong><br/><br/> Если не регистрировались на сайте %1$s, значит это сообщение вы получили по ошибке. Пожалуйста, проигнорируйте его.';
$phrases['email_activation_altbody'] = 'Здравствуйте, \n\n для входа в систему вам нужно сначала активировать ваш аккаунт. Перейдите пожалуйста по этой ссылке: \n %1$s/%2$s \n\n и введите следующий ключ активации: %3$s \n\n Если не регистрировались на сайте %1$s, значит это сообщение вы получили по ошибке. Пожалуйста, проигнорируйте его.';

$phrases['email_reset_subject'] = "%s - Запрос сброса пароля";
$phrases['email_reset_body'] = 'Здравствуйте,<br/><br/>Для сброса вашего пароля пройдите пожалуйста по этой ссылке:<br/><br/><strong><a href="%1$s/%2$s">%1$s/%2$s</a></strong><br/><br/>Вам нужно будет использовать следующий ключ для сброса пароля: <strong>%3$s</strong><br/><br/>Если вы недавно не запрашивали сброс пароля на сайте %1$s, значит это сообщение вы получили по ошибке. Пожалуйста, проигнорируйте его.';
$phrases['email_reset_altbody'] = 'Здравствуйте, \n\n Для сброса вашего пароля пройдите пожалуйста по этой ссылке: \n %1$s/%2$s\n\n Вам нужно будет использовать следующий ключ для сброса пароля: %3$s\n\n Если вы недавно не запрашивали сброс пароля на сайте %1$s, значит это сообщение вы получили по ошибке. Пожалуйста, проигнорируйте его.';

$phrases['account_deleted'] = "Учётная запись удалена.";
$phrases['function_disabled'] = "Эта функция была отключена.";