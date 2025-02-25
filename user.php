<?php

include 'header.php';
?>


<form method="post" action="addUser.php">
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button class="btn btn-primary" type="submit">Register now</button>
</form>
<hr>
<?php

include 'footer.php';

?>
