<?php
session_start(); 
require 'connect.php';
?>

<DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang web PHP - Hỗ trợ</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<header>
    <nav class="navbar navbar-expand-sm navbar-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="logo.png" alt="Scord logo" width="50" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="modules.php">Modules</a>
            </li>       
            <li class="nav-item">
              <a class="nav-link" href="post.php">Post</a>
            </li>  
          </ul>
          <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
          <?php if (!isset($_SESSION['user'])) : ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="signup.php">Signup</a>
            </li>
          <?php endif; ?>
          <?php if (isset($_SESSION['user'])) : ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo $_SESSION['user']['name'] ?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              </ul>
            </li>
          <?php endif; ?>
              <li class="nav-item">
                <a class="nav-link" href="support.php">Contact</a>
              </li>
            </ul>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <h2>Submit a support request</h2>
          <form action="mail.php" method="post">
            <div class="mb-3">
              <label for="title" class="form-label">Title:</label>
              <input type="title" id="title" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="message" class="form-label">Your message</label>
              <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
            </div>
            <button value="send" type="submit" class="btn btn-primary">Send</button>
          </form>
        </div>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
