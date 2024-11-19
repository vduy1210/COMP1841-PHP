<?php
require 'connect.php';
require 'auth.php';
// Check if the user is logged in
// Retrieve posts from the database
$query = $db->prepare('SELECT * FROM posts');
$query->execute();
$posts = $query->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scord</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin') : ?>
            <li class="nav-item">
                <a class="nav-link" href="users.php">Manage Users</a>
            </li>
            <?php endif; ?>
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

  <div class="container mt-4">
  <?php foreach ($posts as $post) : ?>
    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
        <p class="card-text"><?php echo htmlspecialchars($post['content']); ?></p>
        <?php if (!empty($post['image'])) : ?>
          <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" style="max-width: 100%; height: auto;">
        <?php endif; ?>
        <p class="card-text"><small class="text-muted">Posted by <?php echo htmlspecialchars($post['author']); ?></small></p>
        <!-- Edit and Delete buttons -->
        <form action="edit_post.php" method="get">
          <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
          <button type="submit" class="btn btn-primary">Edit</button>
        </form>
        <form action="delete_post.php" method="post" onsubmit="return confirmDelete();">
          <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</div>

</script>
</body>
</html>