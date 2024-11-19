<?php
session_start();
require 'connect.php';

// Redirect if not logged in

// User is logged in, fetch user details from session
$userId = $_SESSION['user']['id'];
$userName = $_SESSION['user']['name'];

// Fetch modules for the form dropdown
$sql = "SELECT id, name FROM modules";
$stmt = $db->prepare($sql);
$stmt->execute();
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $module_id = $_POST['module_id'];
    $author = $userId; // Use logged in user's ID as author

    // Handle the file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'image/';
        $uploadedFile = $uploadDir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
            $imagePath = $uploadedFile;
        } else {
            $imagePath = null;
        }
    } else {
        $imagePath = null;
    }

    // Insert post into database
    $sql = "INSERT INTO posts (title, content, module_id, author, image) VALUES (:title, :content, :module_id, :author, :image)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':module_id', $module_id);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':image', $imagePath);
    $stmt->execute();

    // Redirect after post
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <title>Ask a Question</title>
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
                <?php echo isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : ''; ?>
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

  <main class="container mt-5">
  <h1>Ask a Question</h1>
  <button id="showPostQuestionFormButton" class="btn btn-primary">Post Question</button>
  <div id="postQuestionForm" style="display: none;">
    <form method="POST" action="#" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="title" class="form-label">Question Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Upload Image (Optional)</label>
        <input type="file" class="form-control" id="image" name="image">
      </div>

      <div class="form-group">
      <select name="module_id" id="module_id" class="form-control" required>
        <option value="">-- Choose a module --</option>
        <?php foreach ($modules as $row): ?>
            <option value="<?php echo htmlspecialchars($row['id']); ?>">
                <?php echo htmlspecialchars($row['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
      </div>

      <div class="mb-3">
        <label for="content" class="form-label">Question Details</label>
        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit Question</button>
    </form>
  </div>
</main>

<script>
document.getElementById('showPostQuestionFormButton').addEventListener('click', function() {
    var form = document.getElementById('postQuestionForm');
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
});
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>