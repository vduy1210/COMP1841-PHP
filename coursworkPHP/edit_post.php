<?php
session_start();
require 'connect.php';

// Fetch the post to be edited
$postId = $_GET['id'];
$sql = "SELECT * FROM posts WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $postId);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

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

    // Handle file upload
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


    // Update post in database
    $sql = "UPDATE posts SET title = :title, content = :content, module_id = :module_id, image = :image WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $postId);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':module_id', $module_id);
    $stmt->bindParam(':image', $imagePath);
    $stmt->execute();

    // Redirect after post
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
</head>
<body>
<form action="edit_post.php?id=<?php echo $postId; ?>" method="post" enctype="multipart/form-data">
  <div>
    <label for="title">Title</label>
    <input type="text" id="title" name="title" value="<?php echo $post['title']; ?>" required>
  </div>
  <div>
    <label for="content">Content</label>
    <textarea id="content" name="content" rows="5" required><?php echo $post['content']; ?></textarea>
  </div>
  <div>
    <label for="module_id">Module</label>
    <select id="module_id" name="module_id">
      <?php foreach ($modules as $module) : ?>
        <option value="<?php echo $module['id']; ?>" <?php if ($module['id'] == $post['module_id']) echo 'selected'; ?>>
          <?php echo $module['name']; ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div>
    <label for="image">Image</label>
    <input type="file" id="image" name="image">
  </div>
  <button type="submit">Update Post</button>
</form>
</body>
</html>