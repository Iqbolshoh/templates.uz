<?php include 'check.php' ?>

<?php
$user = $query->select('users', '*')[0];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $username = $_POST['username'];
  $password = $query->hashPassword($_POST['password']);

  $data = [
    'name' => $name,
    'username' => $username,
    'password' => $password
  ];

  $query->update('users', $data, "WHERE id = {$user['id']}");

  echo "<script>
  document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
          icon: 'success',
          title: 'Successfully updated!',
          text: 'User information has been updated!',
          confirmButtonText: 'OK'
      }).then((result) => {
          window.location.href = './';
      });
  });
</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update User</title>
  <!-- CSS includes -->
  <?php include 'includes/css.php'; ?>
  <link href="../favicon.ico" rel="icon">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include 'includes/header.php' ?>
    <div class="content-wrapper">

      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-6 mx-auto">
              <!-- User update form -->
              <div class="card" style="margin-top: 50px">
                <div class="card-header">
                  <h3 class="card-title">Update User</h3>
                </div>

                <!-- Form starts here -->
                <form action="" method="POST" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="name">Full Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name"
                        value="<?php echo $user['name'] ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" id="username" name="username" placeholder="Enter username"
                        value="<?php echo $user['username'] ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter password" required>
                    </div>
                  </div>

                  <!-- Submit button -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
      </section>
    </div>

    <!-- Main Footer -->
    <?php include 'includes/footer.php'; ?>
  </div>

  <!-- SCRIPTS -->
  <?php include 'includes/js.php' ?>
</body>

</html>