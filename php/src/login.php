<?php

ob_start();     // output buffer is need here to prevent header errors



require 'functions.php';
// echo ini_get("session.gc_maxlifetime");
// ini_set("session.gc_maxlifetime", 60);
// echo ini_get("session.gc_maxlifetime");
session_start([]);

require 'header.html';

echo '<div class="general-wrapper">';
echo '<div class="other-general-wrapper">';

if (isset($_POST['submit_button'])) {
    // there is no signup so we don't care about a potentional mismatch with stripped tags
    $email = strip_tags(trim($_POST['email']));
    $password = strip_tags(trim($_POST['password']));
    // var_dump($password);
    // hashing
    // $password = password_hash("$password", PASSWORD_DEFAULT);
    // var_dump($password);
    $errors = [];
    if (empty($email)) {
        $errors['email'] = "<p style='color: red' >Email ass obligatoresch</p>";
    }
    if (empty($password)) {
        $errors['password'] = "<p style='color: red' >Passwuert ass obligatoresch</p>";
    }
    if (empty($errors)) {
        $db = db_connect_delfin();   // function   // also using the variable $db

        // SLQ query with password's hash fetch

        // unsafe SQL query
        // $query = "SELECT * FROM Accounts WHERE username='$username'";
        // $result = mysqli_query($db, $query);        // $db ; function call ?????
        // $user = mysqli_fetch_assoc($result);

        // SQL Injection protection
        $stmt = $db->prepare("SELECT * FROM Accounts WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // closing db for security (and performance) reasons
        $stmt->close();     // also doing this
        db_close_delfin($db);
        // 
        if ($user) {
            $passwordVerify = password_verify($password, $user['password']);    // db password must be hashed

            if ($passwordVerify) {
                $_SESSION['id'] = (int) $user['id'];
                $_SESSION['email'] = (trim($user['email']));
                $_SESSION['username'] = (trim($user['username']));
                // expansion
                $_SESSION['signatureName'] = (trim($user['signatureName']));
                $_SESSION['signaturePhone'] = (trim($user['signaturePhone']));
                $_SESSION['signatureService'] = (trim($user['signatureService']));
                // optional expansion
                $_SESSION['signatureTitle'] = (trim($user['signatureTitle']));
                $_SESSION['signatureOffice'] = (trim($user['signatureOffice']));
                $_SESSION['signatureGSM'] = (trim($user['signatureGSM']));
                $_SESSION['signatureFax'] = (trim($user['signatureFax']));
                // finally
                header("location: delfin.php");
                exit();
            } else {
                echo "<strong>Passwuert falsch</strong><br />";
                // var_dump($user['password']);
            }
        }
        else {
            echo "<strong>Email falsch</strong><br />";
        }
    }
}
?>




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
    <label for="email"></label>
    <?php if (isset($errors['email'])) echo $errors['email']; ?>
    <input type="text" name="email" id="" placeholder="Email">
    <label for="password"></label>
    <?php if (isset($errors['password'])) echo $errors['password']; ?>
    <input type="password" name="password" id="" placeholder="********">
    <input type="submit" value="Log in" name="submit_button" id="">
</form>

</div>
</div>

<?php require 'footer.html'; ?>


