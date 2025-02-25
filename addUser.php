<?php

require 'config/db.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user';
    $hasFidelity = 0;

    $query = $db->prepare('INSERT INTO user (email, password, role, has_fidelity) VALUES (:email, :password, :role, :hasFidelity)');
    $query->bindParam('email', $email);
    $query->bindParam('password', $password);
    $query->bindParam('role', $role);
    $query->bindParam('hasFidelity', $hasFidelity);
    $query->execute();

    header('Location: index.php');
}
