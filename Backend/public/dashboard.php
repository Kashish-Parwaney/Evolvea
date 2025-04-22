<?php
require '../config/config.php';
require '../src/User.php';
require '../src/Auth.php';

session_start();
$user = new User($pdo);
$auth = new Auth($user);
