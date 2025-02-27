<?php
session_start();
if (isset($_POST['submit_button'])) {
    // there is no signup so we don't care about a potentional mismatch with stripped tags
    $username = strip_tags(trim($_POST['username']));
    $password = strip_tags(trim($_POST['password']));
    $errors = [];

    if (empty($_POST['username'])) {
        $errors[] = "Username can not be empty";
    }
    if (empty($_POST['password'])) {
        $errors[] = "Password can not be empty";
    }

    if (!empty($errors)) {
        foreach ($errors as  $error) {
            echo $error . "<br>";
        }
    } else {
        // require 'db_connect.php';
        $_SESSION['username'] = $_POST['username'];
        header('location: delfin.php');
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
    <?php if(isset($errors['username'])) echo $errors['username'];?>
    <input type="text" name="username" id="" placeholder="Usernum" >
    <label for="password"></label>
    <?php if(isset($errors['password'])) echo $errors['password'];?>
    <input type="password" name="password" id="" placeholder="********" >
    <input type="submit" value="Log in" name="submit_button" id="">
</form>


<?php require 'footer.html'; ?>
