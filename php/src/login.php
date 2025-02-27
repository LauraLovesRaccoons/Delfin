<?php

ob_start();     // output buffer removes header warnings : output buffer

require 'functions.php';

session_start();
if (isset($_POST['submit_button'])) {
    // there is no signup so we don't care about a potentional mismatch with stripped tags
    $username = strip_tags(trim($_POST['username']));
    $password = strip_tags(trim($_POST['password']));
    // $username = $_POST['username'];
    // $password = $_POST['password'];
    $errors = [];
    if (empty($username)) {
        $errors['username'] = "<p style='color: red' >A username is required</p>";
    }
    if (empty($password)) {
        $errors['password'] = "<p style='color: red' >A password is required</p>";
    }
    if (empty($errors)) {
        $db = db_connect();   // function   // also using the variable $db
        $query = "SELECT * FROM Accounts WHERE username='$username'";
        $result = mysqli_query($db, $query);        // $db ; function call ?????
        $user = mysqli_fetch_assoc($result);
        $passwordVerify = password_verify($password, $user['password']);

        if ($passwordVerify) {
            $_SESSION['id'] = $user['id'];
            header("location: delfin.php");
            exit();
        } else {
            echo "Username or Password incorrect";
            var_dump($user['password']);
        }
    }
}
?>

<?php require 'header.html'; ?>


<!-- <form method="POST"> -->
<!-- required field is just for GUI ; it's back end verfied -->
<!-- <label for="username"></label>
    <input type="text" name="username" id="username" placeholder="Usernum" required>
    <label for="password"></label>
    <input type="password" name="password" id="password" placeholder="********" required>
    <label for="submit"></label>
    <input type="submit" name="submit" id="submit" value="Login">
</form> -->

<form method="POST">
    <label for="username"></label>
    <?php if (isset($errors['username'])) echo $errors['username']; ?>
    <input type="text" name="username" id="" placeholder="Usernum">
    <label for="password"></label>
    <?php if (isset($errors['password'])) echo $errors['password']; ?>
    <input type="password" name="password" id="" placeholder="********">
    <input type="submit" value="Log in" name="submit_button" id="">
</form>


<?php require 'footer.html'; ?>