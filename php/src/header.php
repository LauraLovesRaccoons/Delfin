<!DOCTYPE html>
<html lang="en-lu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= getenv('APP_NAME') ?: 'Delfin' ?></title>
    <!-- icons and more icons -->
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="favicon.ico" />
    <!-- (S)CSS stylesheet-->
    <link rel="stylesheet" href="./styles/main.css" />
    <!-- font awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>
    <header>
      <ul>
        <li><a href="delfin.php"><i class="fa-solid fa-house"></i>Home</a></li>
        <li><a href="logout.php"><i class="fa-solid fa-door-closed"></i>Logout</a></li>
      </ul>
      <hr />
    </header>
    