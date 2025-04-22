<?php
class Auth {
    private $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function login($username, $password) {
        $userData = $this->user->findByUsername($username);
        if ($userData && password_verify($password, $userData['password'])) {
            session_start();
            $_SESSION['user_id'] = $userData['id'];
            return true;
        }
        return false;
    }

    public function logout() {
        session_start();
        session_destroy();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}
?>