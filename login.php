<?php

include 'header.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    require 'config/db.php';

    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $user = $db->query("SELECT * FROM user WHERE email = '$email'")->fetch();

    if (!$user) {
        echo 'User not found';
        exit;
    }

    if (!password_verify($password, $user['password'])) {
        echo 'Invalid password';
        exit;
    }

    $_SESSION['user'] = $user;
    header('Location: index.php');
    exit;
}


?>

<form method="post" action="login.php">
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button class="btn btn-primary" type="submit">Login now</button>
</form>
<hr>
<?php

include 'footer.php';

?>
