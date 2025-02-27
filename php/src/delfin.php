<?php session_start();

if(isset($_POST['logout_button']))
{
    unset($_SESSION['username']);
    header("location: logout.php");
}

if(isset($_SESSION['username']))
{
    echo "Welcome: $_SESSION[username]";
}else {
    header("location: index.php");  // this requires a session from login
}



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

