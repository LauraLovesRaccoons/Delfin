<?php

session_start();
if (isset($_POST['submit_button'])) {
    echo "<br /><h1>Generate a Hash for your Password</h1><br />";
    $password = strip_tags(trim($_POST['password']));
    echo "<br /><h1>This is your password which is sql query safe ; might be different from the inputed one!!!</h1><br />";
    var_dump($password);
    $password = password_hash("$password", PASSWORD_DEFAULT);
    echo "<br /><h1>This should be entered into the databse!!!</h1><br />";
    var_dump($password);
    echo "<br /><br /><br />---<br /><br /><br />";
}

?>


<?php require 'header.html'; ?>

<form method="POST">
    <label for="password"></label>
    <?php if (isset($errors['password'])) echo $errors['password']; ?>
    <!-- input type username to make it visible for this very specific use case -->
    <input type="username" name="password" id="" placeholder="********">
    <input type="submit" value="Generate Hash" name="submit_button" id="">
</form>


<br /><br /><br /><br />
<a href="index.php">Go Back</a>
<br /><br /><br /><br />



<?php require 'footer.html'; ?>
