<?php session_start();

require "functions.php";
session_checker();



?>




<h1>LOGGED IN</h1>
<br />
<h1>This needs a session from login to work</h1>
<?php
// if (!isset($_SESSION['loggedin'])) {
//     header('Location: index.html');
//     exit;
// }
?>

<h2>:farewell:</h2>
<form method="post">
    <input type="submit" value="log out" name="logout_button">
</form>

