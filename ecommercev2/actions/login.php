<?php

require_once '../models/User.php';
require_once '../models/Session.php';
require_once '../connection/DbManager.php';
require_once '../models/Cart.php';

session_start();
$email = $_POST["email"];
$password = hash('sha256', $_POST["password"]);

$pdo = DbManager::Connect("ecommerce");

$stmt = $pdo->prepare("SELECT id, email, password FROM ecommerce.users WHERE email = :email");
$stmt->bindParam(":email", $email);
$stmt->execute();
$user = $stmt->fetchObject("User");

if (!$user) {
    header('Location: http://localhost:63342/ecommercev2/views/signup.php');
    exit;
} else {
    $_SESSION['current_user'] = $user;
    $params = array('ip' => '127.0.0.1', 'data_login' => date('d/m/y H:i:s'), 'user_id' => $user->GetId());
    $_SESSION['object_session'] = Session::Create($params);
    $params = array("user_id"=>$user->GetId());
    $cart = Cart::Create($params);
    header('Location: http://localhost:63342/ecommercev2/views/products/index.php');
    exit;
}
?>



