<?php

class Auth {
    private $user;

    public function __construct($user){
        $this->user = $user;
    }

    public function login($username, $password){
        $record = $this->user->findByUsername($username);

        if($record && password_verify($password, $record['password'])){
            $_SESSION['user_id']   = $record['id'];
            $_SESSION['user_name'] = $record['name'];
            $_SESSION['user_role'] = $record['role'];
            return true;
        }

        return false;
    }

    public function logout(){
        // Clear all session variables
        $_SESSION = [];

        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        header("Location: login.php");
        exit();
    }

    public static function check(){
        if(!isset($_SESSION['user_id'])){
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Pragma: no-cache");
            header("Location: login.php");
            exit();
        }
    }

    public static function isLoggedIn(){
        return isset($_SESSION['user_id']);
    }
}

?>