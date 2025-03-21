<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include("../config/database.php");
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Management User Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="../pages/dashboard.php">Management User</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto">
          <?php if (isset($_SESSION['user_id'])): ?>
            <a class="nav-link active" aria-current="page" href="../pages/dashboard.php">Dashboard</a>
            <a href="../actions/logout_action.php" class="bg-red-500 text-black px-4 py-2 rounded">Logout</a>
          <?php else: ?>
            <a class="nav-link active" aria-current="page" href="../pages/login.php">Login</a>
            <a class="nav-link active" aria-current="page" href="../pages/signup.php">Signup</a>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </nav>