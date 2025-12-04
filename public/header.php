<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$current_page = basename($_SERVER['PHP_SELF']);

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notes App</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Animate.css for small animations -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Optional custom css -->
  <link rel="stylesheet" href="/notes-app/public/assets/css/style.css">
</head>
<style>
    .nav-link.active {
    border-bottom: 2px solid #0d6efd;
}
</style>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="/notes-app/public/index.php">NotesApp</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
            aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        
        <?php if (!empty($_SESSION['user_id'])): ?>

          <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active fw-bold text-primary' : '' ?>"
               href="/notes-app/public/dashboard.php">Dashboard</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'my_notes.php') ? 'active fw-bold text-primary' : '' ?>"
               href="/notes-app/public/my_notes.php">My Notes</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'profile.php') ? 'active fw-bold text-primary' : '' ?>"
               href="/notes-app/public/profile.php">Profile</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-danger" href="/notes-app/public/logout.php">Logout</a>
          </li>

        <?php else: ?>

          <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'login.php') ? 'active fw-bold text-primary' : '' ?>"
               href="/notes-app/public/login.php">Login</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'register.php') ? 'active fw-bold text-primary' : '' ?>"
               href="/notes-app/public/register.php">Register</a>
          </li>

        <?php endif; ?>
        
      </ul>
    </div>
  </div>
</nav>


<main class="container py-4">
