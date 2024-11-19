<?php
session_start(); 
require 'connect.php';


// Xử lý khi có request method là POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    // Kiểm tra xem tên module đã tồn tại chưa
    $query = $db->prepare('SELECT name FROM modules WHERE name = :name');
    $query->bindValue(':name', $name);
    $query->execute();
    $result = $query->fetch();

    if (!$result) {
        // Nếu chưa tồn tại, thêm mới vào database
        $query = $db->prepare('INSERT INTO modules (name) VALUES (:name)');
        $query->bindParam(':name', $name);
        $query->execute();
        $success = "Module created successfully!";
    } else {
        $error = "Module already exists!";
    }
}

// Lấy danh sách các module từ database
$query = $db->prepare('SELECT * FROM modules');
$query->execute();
$modules = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modules</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

<main class="container mt-5">
    <h1 class="text-center">Available Modules</h1>

    <!-- Form to create new module -->
    <div class="container fluid">
        <?php if (isset($error)) : ?>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($success)) : ?>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <button id="showFormButton" class="btn btn-primary">Create a Module</button>

    <form id="createForm" action="#" method="POST" class="form-inline" role="form" style="display: none;">
        <input type="text" class="form-control" name="name" placeholder="Input name of module">
        <button type="submit" class="btn btn-primary">Create the moudle</button>
    </form>

    <hr>

    <!-- Display existing modules -->
    <?php if (!empty($modules)) : ?>
        <div class="row">
            <div class="col-md-5">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Module name</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($modules as $row): ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><a href="delete_module.php?id=<?php echo $row['id'] ?>">Delete</a></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif ?>

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<!-- Script to toggle form visibility -->
<script>
    document.getElementById('showFormButton').addEventListener('click', function () {
        var form = document.getElementById('createForm');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });
</script>
</body>
</html>
