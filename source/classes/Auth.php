<?php

namespace radio\classes;
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 21.05.2018
 * Time: 15:24
 */
class Auth
{
    public $config;
    public $phrases;


    public function __construct()
    {
        $this->config = new Config();

        // Загружаем фразы
        require $_SERVER['DOCUMENT_ROOT']."/source/helpers/authPhrases.php";
        $this->phrases = $phrases;

        date_default_timezone_set($this->config->site_timezone);
    }

    public function login($email, $password, $remember = 0, $captcha = null)
    {
        $return['error'] = true;
        
        $blockStatus = $this->isBlocked();

        if ($blockStatus == "verify") {
            if ($this->checkCaptcha($captcha) == false) {
                $return['message'] = $this->phrases["user_verify_failed"];
                return $return;
            }
        }

        if ($blockStatus == 'block') {
            $return['message'] = $this->phrases['user_blocked'];
            return $return;
        }

        $validateEmail = $this->validateEmail($email);
        $validatePassword = $this->validatePassword($password);

        if ($validateEmail['error'] == 1) {
            $this->addAttempt();
            $return['message'] = $this->phrases["email_invalid"];

            return $return;
        } elseif ($validatePassword['error'] == 1) {
            $this->addAttempt();
            $return['message'] = $this->phrases["email_password_invalid"];

            return $return;
        } elseif ($remember != 0 && $remember != 1) {
            $this->addAttempt();
            $return['message'] = $this->phrases["remember_me_invalid"];

            return $return;
        }

        $uid = $this->getUID(strtolower($email));

        if (!$uid) {
            $this->addAttempt();
            $return['message'] = $this->phrases["email_password_incorrect"];

            return $return;
        }

        $user = $this->getBaseUser($uid);

        if (!password_verify($password, $user['password'])) {
            $this->addAttempt();
            $return['message'] = $this->phrases["email_password_incorrect"];

            return $return;
        }

        if ($user['isactive'] != 1) {
            $this->addAttempt();
            $return['message'] = $this->phrases["account_inactive"];

            return $return;
        }

        $sessionData = $this->addSession($user['uid'], $remember);

        if ($sessionData == false) {
            $return['message'] = $this->phrases["system_error"] . " #01";

            return $return;
        }

        $return['error'] = false;
        $return['message'] = $this->phrases["logged_in"];

        $return['hash'] = $sessionData['hash'];
        $return['expire'] = $sessionData['expiretime'];
        return $return;
    }

    /**
     * Получаем ip адрес
     * @return string $ip
     */
    protected function getIp()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Удаляем все попытки для данного IP из базы
     * @param string $ip
     * @param boolean $all = false
     * @return boolean
     */

    protected function deleteAttempts($ip, $all = false)
    {
        if ($all == true) {
            $sql = "DELETE FROM {$this->config->table_attempts} WHERE ip = ?";
            return DataBase::PDOStatement($sql, array($ip));
        }

        $sql = "SELECT id, expiredate FROM {$this->config->table_attempts} WHERE ip = ?";
        $result = DataBase::PDOStatement($sql, array($ip));

        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $expireDate = strtotime($row['expiredate']);
            $currentDate = strtotime(date("Y-m-d H:i:s"));
            if ($currentDate > $expireDate) {
                $sql = "DELETE FROM {$this->config->table_attempts} WHERE id = ?";
                DataBase::PDOStatement($sql, array($row['id']));
            }
        }
    }

    public function isBlocked()
    {
        $ip = $this->getIp();
        $this->deleteAttempts($ip, false);

        $sql = "SELECT count(*) FROM {$this->config->table_attempts} WHERE ip = ?";
        $result = DataBase::PDOStatement($sql, array($ip));
        $attempts = $result->fetchColumn();

        if ($attempts < intval($this->config->attempts_before_verify)) {
            return "allow";
        }

        if ($attempts < intval($this->config->attempts_before_ban)) {
            return "verify";
        }

        return "block";
    }

    /**
     * Проверяет капчу, пока возвращает просто true
     * скорее всего капчи и не будет
     * @param string $captcha
     * @return boolean
     */
    protected function checkCaptcha($captcha)
    {
        return true;
    }

    /**
     * Проверка email на правильность
     * @param string $email
     * @return array $return
     */

    protected function validateEmail($email) {
        $return['error'] = true;

        if (strlen($email) < (int)$this->config->verify_email_min_length ) {
            $return['message'] = $this->phrases["email_short"];

            return $return;
        } elseif (strlen($email) > (int)$this->config->verify_email_max_length ) {
            $return['message'] = $this->phrases["email_long"];

            return $return;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $return['message'] = $this->phrases["email_invalid"];

            return $return;
        }

        if ( (int)$this->config->verify_email_use_banlist ) {
            $bannedEmails = json_decode(file_get_contents("files/domains.json"));

            if (in_array(strtolower(explode('@', $email)[1]), $bannedEmails)) {
                $return['message'] = $this->phrases["email_banned"];

                return $return;
            }
        }

        $return['error'] = false;

        return $return;
    }

    /**
     * Проверка пароля на правильность
     * @param string $password
     * @return array $return
     */

    protected function validatePassword($password) {
        $return['error'] = true;

        if (strlen($password) < (int)$this->config->verify_password_min_length ) {
            $return['message'] = $this->phrases["password_short"];

            return $return;
        }

        $return['error'] = false;

        return $return;
    }

    /**
     * Добавить попытку подключения в базу
     * @return boolean
     */

    protected function addAttempt()
    {
        $ip = $this->getIp();
        $attemptExpiredate = date("Y-m-d H:i:s", strtotime($this->config->attack_mitigation_time));
        $sql = "INSERT INTO {$this->config->table_attempts} (ip, expiredate) VALUES (?, ?)";
        return DataBase::PDOStatement($sql, array($ip, $attemptExpiredate));
    }

    /**
     * Получение UID по почтовому ящику
     * @param string $email
     * @return array $uid
     */


    public function getUID($email)
    {
        $sql = "SELECT id FROM {$this->config->table_users} WHERE email = ?";
        $result = DataBase::PDOStatement($sql, array($email));

        if ($result->rowCount() == 0) {
            return false;
        }

        return $result->fetch(\PDO::FETCH_ASSOC)['id'];
    }

    /**
     * Получаем базового пользователя по UID
     * @param int $uid
     * @return int $data
     */

    protected function getBaseUser($uid)
    {
        $sql = "SELECT email, password, isactive FROM {$this->config->table_users} WHERE id = ?";
        $result = DataBase::PDOStatement($sql, array($uid));

        if ($result->rowCount() == 0) {
            return false;
        }

        $data = $result->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return false;
        }

        $data['uid'] = $uid;

        return $data;
    }
    /**
    * Создаем сеанс для указанного идентификатора пользователя
    * @param int $uid
    * @param boolean $remember
    * @return array $data
    */

    protected function addSession($uid, $remember)
    {
        $ip = $this->getIp();
        $user = $this->getBaseUser($uid);

        if (!$user) {
            return false;
        }

        $data['hash'] = sha1($this->config->site_key . microtime());
        $agent = $_SERVER['HTTP_USER_AGENT'];

        $this->deleteExistingSessions($uid);

        if ($remember == true) {
            $data['expire'] = date("Y-m-d H:i:s", strtotime($this->config->cookie_remember));
            $data['expiretime'] = strtotime($data['expire']);
        } else {
            $data['expire'] = date("Y-m-d H:i:s", strtotime($this->config->cookie_forget));
            $data['expiretime'] = 0;
        }

        $data['cookie_crc'] = sha1($data['hash'] . $this->config->site_key);

        $sql = "INSERT INTO {$this->config->table_sessions} (uid, hash, expiredate, ip, agent, cookie_crc) VALUES (?, ?, ?, ?, ?, ?)";
        $result = DataBase::PDOStatement($sql, array($uid, $data['hash'], $data['expire'], $ip, $agent, $data['cookie_crc']));

        if (!$result) {
            return false;
        }

        $data['expire'] = strtotime($data['expire']);

        return $data;
    }

    /**
     * Удаляем все существующие сессии для данного UID
     * @param int $uid
     * @return boolean
     */

    protected function deleteExistingSessions($uid)
    {
        $sql = "DELETE FROM {$this->config->table_sessions} WHERE uid = ?";
        $result = DataBase::PDOStatement($sql, array($uid));

        return $result->rowCount() == 1;
    }

    /**
     * Создаем нового пользователя, добавляем в базу
     * @param string $email
     * @param string $password
     * @param string $repeatPassword
     * @param array  $params
     * @param string $captcha = NULL
     * @param bool $sendMail = NULL
     * @return array $return
     */

    public function register($email, $password, $repeatPassword, $params = Array(), $captcha = NULL, $sendMail = NULL)
    {
        $return['error'] = true;
        $blockStatus = $this->isBlocked();

        if ($blockStatus == "verify") {
            if ($this->checkCaptcha($captcha) == false) {
                $return['message'] = $this->phrases["user_verify_failed"];

                return $return;
            }
        }

        if ($blockStatus == "block") {
            $return['message'] = $this->phrases["user_blocked"];

            return $return;
        }

        if ($password !== $repeatPassword) {
            $return['message'] = $this->phrases["password_nomatch"];

            return $return;
        }

        // Validate email
        $validateEmail = $this->validateEmail($email);

        if ($validateEmail['error'] == 1) {
            $return['message'] = $validateEmail['message'];

            return $return;
        }

        // Validate password
        $validatePassword = $this->validatePassword($password);

        if ($validatePassword['error'] == 1) {
            $return['message'] = $validatePassword['message'];

            return $return;
        }


        if ($this->isEmailTaken($email)) {
            $this->addAttempt();
            $return['message'] = $this->phrases["email_taken"];

            return $return;
        }

        $addUser = $this->addUser($email, $password, $params, $sendMail);

        if ($addUser['error'] != 0) {
            $return['message'] = $addUser['message'];

            return $return;
        }

        $return['error'] = false;
        $return['message'] = ($sendMail == true ? $this->phrases["register_success"] : $this->phrases['register_success_emailmessage_suppressed'] );

        return $return;
    }

    /**
     * Проверяем не занят ли пароль
     * @param string $email
     * @return boolean
     */

    public function isEmailTaken($email)
    {
        $sql = "SELECT count(*) FROM {$this->config->table_users} WHERE email = ?";
        $result = DataBase::PDOStatement($sql, array($email));


        if ($result->fetchColumn() == 0) {
            return false;
        }

        return true;
    }

    /**
     * Добавляем нового пользователя в базу
     * @param string $email      -- email
     * @param string $password   -- password
     * @param array $params      -- additional params
     * @param boolean $sendMail = NULL
     * @return int $uid
     */

    protected function addUser($email, $password, $params = array(), &$sendMail)
    {
        $return['error'] = true;

        $sql = "INSERT INTO {$this->config->table_users} VALUES ()";
        $result = DataBase::PDOStatement($sql);

        if (!$result) {
            $return['message'] = $this->phrases["system_error"] . " #03";
            return $return;
        }

        $uid = DataBase::PDO()->lastInsertId();
        $email = htmlentities(strtolower($email));

        if ($sendMail) {
            $addRequest = $this->addRequest($uid, $email, "activation", $sendMail);

            if ($addRequest['error'] == 1) {
                $sql = "DELETE FROM {$this->config->table_users} WHERE id = ?";
                DataBase::PDOStatement($sql, array($uid));
                $return['message'] = $addRequest['message'];

                return $return;
            }

            $isactive = 0;
        } else {
            $isactive = 1;
        }

        $password = $this->getHash($password);

        if (is_array($params)&& count($params) > 0) {
            $customParamsQueryArray = Array();

            foreach($params as $paramKey => $paramValue) {
                $customParamsQueryArray[] = array('value' => $paramKey . ' = ?');
            }

            $setParams = ', ' . implode(', ', array_map(function ($entry) {
                    return $entry['value'];
                }, $customParamsQueryArray));
        } else { $setParams = ''; }
        $sql = "UPDATE {$this->config->table_users} SET email = ?, password = ?, isactive = ? {$setParams} WHERE id = ?";
        $bindParams = array_values(array_merge(array($email, $password, $isactive), $params, array($uid)));
        $result = DataBase::PDOStatement($sql,$bindParams);

        if (!$result) {
            $sql = "DELETE FROM {$this->config->table_users} WHERE id = ?";
            DataBase::PDOStatement($sql,array($uid));
            $return['message'] = $this->phrases["system_error"] . " #04";

            return $return;
        }

        $return['error'] = false;
        return $return;
    }

    /**
     * Создаем информацию для активации и отправляем пользователю
     * @param int $uid
     * @param string $email
     * @param string $type
     * @param boolean $sendMail = NULL
     * @return boolean
     */

    protected function addRequest($uid, $email, $type, &$sendMail)
    {
        $return['error'] = true;

        if ($type != "activation" && $type != "reset") {
            $return['message'] = $this->phrases["system_error"] . " #08";

            return $return;
        }

        // если не установили вручную, проверьте данные конфигурации
        if ($sendMail === NULL) {
            $sendMail = true;
            if ($type == "reset" && $this->config->emailmessage_suppress_reset === true ) {
                $sendMail = false;
                $return['error'] = false;

                return $return;
            }

            if ($type == "activation" && $this->config->emailmessage_suppress_activation === true ) {
                $sendMail = false;
                $return['error'] = false;

                return $return;
            }
        }

        $sql = "SELECT id, expire FROM {$this->config->table_requests} WHERE uid = ? AND type = ?";
        $result = DataBase::PDOStatement($sql, array($uid, $type));

        if ($result->rowCount() > 0) {
            $row = $result->fetch(\PDO::FETCH_ASSOC);

            $expireDate = strtotime($row['expire']);
            $currentDate = strtotime(date("Y-m-d H:i:s"));

            if ($currentDate < $expireDate) {
                $return['message'] = $this->phrases["reset_exists"];

                return $return;
            }

            $this->deleteRequest($row['id']);
        }

        if ($type == "activation" && $this->getBaseUser($uid)['isactive'] == 1) {
            $return['message'] = $this->phrases["already_activated"];

            return $return;
        }

        $key = $this->getRandomKey(20);
        $expire = date("Y-m-d H:i:s", strtotime($this->config->request_key_expiration));

        $sql = "INSERT INTO {$this->config->table_requests} (uid, rkey, expire, type) VALUES (?, ?, ?, ?)";
        $result = DataBase::PDOStatement($sql, array($uid, $key, $expire, $type));

        if (!$result) {
            $return['message'] = $this->phrases["system_error"] . " #09";

            return $return;
        }

        $request_id = $this->dataBase->pdo()->lastInsertId();

        if ($sendMail === true) {
            // Check configuration for SMTP parameters
            $mail = new PHPMailer;
            $mail->CharSet = $this->config->mail_charset;
            if ($this->config->smtp) {
                $mail->isSMTP();
                $mail->Host = $this->config->smtp_host;
                $mail->SMTPAuth = $this->config->smtp_auth;
                if (!is_null($this->config->smtp_auth)) {
                    $mail->Username = $this->config->smtp_username;
                    $mail->Password = $this->config->smtp_password;
                }
                $mail->Port = $this->config->smtp_port;

                if (!is_null($this->config->smtp_security)) {
                    $mail->SMTPSecure = $this->config->smtp_security;
                }
            }

            $mail->From = $this->config->site_email;
            $mail->FromName = $this->config->site_name;
            $mail->addAddress($email);
            $mail->isHTML(true);

            if ($type == "activation") {
                $mail->Subject = sprintf($this->phrases['email_activation_subject'], $this->config->site_name);
                $mail->Body = sprintf($this->phrases['email_activation_body'], $this->config->site_url, $this->config->site_activation_page, $key);
                $mail->AltBody = sprintf($this->phrases['email_activation_altbody'], $this->config->site_url, $this->config->site_activation_page, $key);
            } else {
                $mail->Subject = sprintf($this->phrases['email_reset_subject'], $this->config->site_name);
                $mail->Body = sprintf($this->phrases['email_reset_body'], $this->config->site_url, $this->config->site_password_reset_page, $key);
                $mail->AltBody = sprintf($this->phrases['email_reset_altbody'], $this->config->site_url, $this->config->site_password_reset_page, $key);
            }

            if (!$mail->send()) {
                $this->deleteRequest($request_id);
                $return['message'] = $this->phrases["system_error"] . " #10";

                return $return;
            }

        }

        $return['error'] = false;

        return $return;
    }

    /**
     * Удаляем запрос из базы данных
     * @param int $id
     * @return boolean
     */

    protected function deleteRequest($id)
    {
        $sql = "DELETE FROM {$this->config->table_requests} WHERE id = ?";
        return DataBase::PDOStatement($sql, array($id));
    }

    /**
     * Возвращаем случайную строку опредленной длины
     * @param int $length
     * @return string $key
     */
    public function getRandomKey($length = 20)
    {
        $chars = "A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6";
        $key = "";

        for ($i = 0; $i < $length; $i++) {
            $key .= $chars{mt_rand(0, strlen($chars) - 1)};
        }

        return $key;
    }

    /**
     * Хешируем пароль
     * @param string $password
     * @return string
     */

    public function getHash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => $this->config->bcrypt_cost]);
    }

    /**
     * Возвращает, авторизован ли пользователь
     * @return boolean
     */
    public function isLogged() {
        return (isset($_COOKIE[$this->config->cookie_name]) && $this->checkSession($_COOKIE[$this->config->cookie_name]));
    }

    /**
     * Проверяем сессии на валдиность
     * @param string $hash
     * @return boolean
     */

    public function checkSession($hash)
    {
        $ip = $this->getIp();
        $blockStatus = $this->isBlocked();

        if ($blockStatus == "block") {
            $return['message'] = $this->phrases["user_blocked"];
            return false;
        }

        if (strlen($hash) != 40) {
            return false;
        }
        $sql = "SELECT id, uid, expiredate, ip, agent, cookie_crc FROM {$this->config->table_sessions} WHERE hash = ?";
        $result = DataBase::PDOStatement($sql, array($hash));

        if ($result->rowCount() == 0) {
            return false;
        }

        $row = $result->fetch(\PDO::FETCH_ASSOC);
        $uid = $row['uid'];
        $expireDate = strtotime($row['expiredate']);
        $currentDate = strtotime(date("Y-m-d H:i:s"));
        $db_ip = $row['ip'];
        $db_cookie = $row['cookie_crc'];

        if ($currentDate > $expireDate) {
            $this->deleteExistingSessions($uid);

            return false;
        }

        if ($ip != $db_ip) {
            return false;
        }

        if ($db_cookie == sha1($hash . $this->config->site_key)) {
            return true;
        }

        return false;
    }

    /**
     * Выходим из сессии, идентифицируем по хешу
     * @param string $hash
     * @return boolean
     */

    public function logout($hash)
    {
        if (strlen($hash) != 40) {
            return false;
        }

        return $this->deleteSession($hash);
    }

    /**
     * Удаляем сессию из базы
     * @param string $hash
     * @return boolean
     */

    protected function deleteSession($hash)
    {
        $sql = "DELETE FROM {$this->config->table_sessions} WHERE hash = ?";
        $result = DataBase::PDOStatement($sql, array($hash));

        return $result->rowCount() == 1;
    }

    /**
     * Получаем id пользователя по хэшу
     * @param string $hash
     * @return integer $uid
     */
    public function getSessionUID($hash)
    {
        $sql = "SELECT uid FROM {$this->config->table_sessions} WHERE hash = ?";
        $result = DataBase::PDOStatement($sql, array($hash));

        if ($result->rowCount() == 0) {
            return false;
        }

        return $result->fetch(\PDO::FETCH_ASSOC)['uid'];
    }
}