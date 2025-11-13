<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$error = false;

if ($_POST) {
    include_once('storage.php');
    $stor = new Storage(new JsonIO('users.json'));
    $user = $stor->findOne(['username' => $username]);

    if (!$user || !password_verify($password, $user['password'])) {
        $error = true;
    } else {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['money'] = $user['amountOfMoneyInWallet'];
        $_SESSION['noOfCards'] = count($user['cards']);
        header('location: index.php');
        exit();
    }
}
?>


