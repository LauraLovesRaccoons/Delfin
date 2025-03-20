<?php

require 'header.html';
// session_start();
if (isset($_POST['submit_button'])) {
    echo "<br /><h2>Generate a Hash for your Password</h2><br />";
    $password = strip_tags(trim($_POST['password']));
    echo "<br /><h3>This is your password which is sql query safe ; might be different from the inputed one!!!</h3><br />";
    // var_dump($password);
    printf("<strong>%s</strong><br />", $password);
    $password = password_hash("$password", PASSWORD_DEFAULT);
    echo "<br /><h3>This should be entered into the database!!!</h3><br />";
    // var_dump($password);
    printf("<strong>%s</strong><br />", $password);
    echo "<br />";

}

?>



<br />
<form method="POST">
    <label for="password"></label>
    <?php if (isset($errors['password'])) echo $errors['password']; ?>
    <!-- input type username to make it visible for this very specific use case -->
    <input type="username" name="password" id="" placeholder="********">
    <input type="submit" value="Generate Hash" name="submit_button" id="">
</form>


<br />
<a href="index.php">Go Back</a>
<br />



<?php require 'footer.html'; ?>


