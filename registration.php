<?php
session_start();
include_once("storage.php");
$stor = new Storage(new JsonIO('users.json'));

$errors = [];
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if ($_POST) {
    $existingUser = $stor->findOne(['username' => $username]);

    if ($existingUser) $errors['username'] = 'Username is already taken.';
    if (empty($username)) $errors['username'] = 'Username cannot be empty.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email.';
    if ($password !== $confirmPassword) $errors['password'] = 'Passwords do not match.';

    if (count($errors) === 0) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = [
            "username" => $username,
            "email" => $email,
            "password" => $hashedPassword,
            "isAdmin" => false,
            "amountOfMoneyInWallet" => 1500,
            "noOfCards" => 0,
            "cards" => []
        ];
        $stor->add($user);
        $_SESSION['user_id'] = $user['id'];
        header("location: index.php");
        exit();
    }
}
?>

