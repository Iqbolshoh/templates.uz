<?php include 'check.php'; ?>

<?php
$banners = $query->select('banners', '*');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {

    if (isset($_FILES['image']) && $_FILES['image']['name']) {
        $originalImage = $_FILES['image']['name'];
        $extension = pathinfo($originalImage, PATHINFO_EXTENSION);
        $timestamp = date('YmdHis');
        $newImageName = uniqid('banner_', true) . '_' . $timestamp . '.' . $extension;

        $target = "../assets/img/banners/" . basename($newImageName);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $button_text = $_POST['button_text'];
            $button_link = $_POST['button_link'];

            $data = [
                'image' => $newImageName,
                'title' => $title,
                'description' => $description,
                'button_text' => $button_text,
                'button_link' => $button_link
            ];

            $query->insert('banners', $data);
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        } else {
            echo "Error occurred while uploading the image.";
        }
    } else {
        echo "No image selected.";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $banner = $query->select('banners', '*', "WHERE id = {$id}");

    if (isset($banner[0])) {
        $banner = $banner[0];
        $imagePath = "../assets/img/banners/" . $banner['image'];

        if (file_exists($imagePath)) {
            if (unlink($imagePath)) {
                $query->delete('banners', "WHERE id = {$id}");
                header("Location: {$_SERVER['PHP_SELF']}");
                exit;
            } else {
                echo "An error occurred while deleting the image.";
            }
        } else {
            echo "Image not found.";
        }
    } else {
        echo "Banner not found for deletion.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Banner Management</title>
    <!-- CSS files -->
    <?php include 'includes/css.php'; ?>
    <link href="../favicon.ico" rel="icon">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/header.php' ?>
        <div class="content-wrapper">

            <section class="content">
                <div class="container-fluid">

                    <!-- Button to add banners -->
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                        data-target="#addBannerModal">
                        Add Banner
                    </button>

                    <!-- Add Banner modal -->
                    <div class="modal fade" id="addBannerModal" tabindex="-1" role="dialog"
                        aria-labelledby="addBannerModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addBannerModalLabel">Add Banner</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="image">Select Image</label>
                                            <input type="file" class="form-control" id="image" name="image"
                                                accept="image/*" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                placeholder="Title" maxlength="255" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description"
                                                placeholder="Description" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="button_text">Button Text</label>
                                            <input type="text" class="form-control" id="button_text" name="button_text"
                                                placeholder="Button text" maxlength="100" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="button_link">Button Link</label>
                                            <input type="text" class="form-control" id="button_link" name="button_link"
                                                placeholder="Button link" maxlength="255" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" name="add" class="btn btn-primary">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Banner list -->
                    <div class="card-header">
                    </div>
                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Button Text</th>
                                <th>Button Link</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($banners as $index => $banner): ?>
                                <tr>
                                    <td><?php echo $index + 1 ?></td>
                                    <td><img src="../assets/img/banners/<?php echo $banner['image']; ?>"
                                            alt="<?php echo $banner['title']; ?>" width="100"></td>
                                    <td><?php echo $banner['title']; ?></td>
                                    <td><?php echo $banner['description']; ?></td>
                                    <td><?php echo $banner['button_text']; ?></td>
                                    <td><?php echo $banner['button_link']; ?></td>
                                    <td>
                                        <button onclick="deleteBanner(<?php echo $banner['id']; ?>)" type="button"
                                            class="btn btn-danger" onclick="deleteProduct(2)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- JS files -->
    <?php include 'includes/js.php'; ?>

    <script>
        function deleteBanner(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this banner!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value == true) {
                    $.ajax({
                        type: 'GET',
                        url: '',
                        data: {
                            action: 'delete',
                            delete: id
                        },
                        success: function (response) {
                            Swal.fire("Deleted!", "Banner deleted successfully!", "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            Swal.fire("Error!", "There was an error deleting the banner.", "error");
                        }
                    });
                }
            });
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>