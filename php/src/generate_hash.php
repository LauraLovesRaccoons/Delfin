<?php

require 'header.html';

echo '<div class="general-wrapper">';
echo '<div class="support_page-wrapper">';

echo '<h1>Support & Account Creation</h1>';
echo '<hr /><br />';
echo '<article>';
echo '<strong>Laura Hornick</strong><br />';
echo '<a href="tel:+352 501251 2069">+352 501251 2069</a><br />';
echo '<a href="mailto:laura.hornick@petange.lu">laura.hornick@petange.lu</a><br />';
echo '</article>';
echo '<br />';
echo '<hr />';
echo '<br />';

// session_start();
if (isset($_POST['submit_button'])) {
    echo "<h2>Generate a Hash for your Password</h2>";
    $password = strip_tags(trim($_POST['password']));
    echo "<h3>This is your password which is sql query safe ; might be different from the inputed one!</h3>";
    // var_dump($password);
    echo "<div>";
    printf("<strong>%s</strong><br />", $password);
    echo "</div>";
    $password = password_hash("$password", PASSWORD_DEFAULT);
    echo "<h3>This should be entered into the database:</h3>";
    // var_dump($password);
    echo "<div>";
    printf("<strong>%s</strong><br />", $password);
    echo "</div>";
    echo "<br />";
    echo "<hr />";
}

?>



<br />
<form class="generate-hash-form" method="POST">
    <label for="password"></label>
    <?php if (isset($errors['password'])) echo $errors['password']; ?>
    <!-- input type username to make it visible for this very specific use case -->
    <input type="username" name="password" id="" placeholder="********" required>
    <input type="submit" value="Generate Hash" name="submit_button" id="">
</form>


<!-- <div class="spacer"></div> -->
<!-- <hr /> -->


<!-- <br />
<a href="index.php">Go Back</a>
<br /> -->

</div>
</div>

<?php require 'footer.html'; ?>

