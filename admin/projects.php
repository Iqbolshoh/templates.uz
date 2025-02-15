<?php
session_start();

include '../config.php';
$query = new Database();
$query->checkUserSession('admin');

// Fetch projects
$projects = $query->select('projects', '*');
$categories = $query->select('category', '*');

// project deletion process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);

    // Delete images
    $imagesUrl = $query->select('project_images', '*', "project_id = ?", [$delete_id], 'i');
    foreach ($imagesUrl as $image) {
        $imageUrl = "../assets/img/projects/" . $image['image_url'];
        if (file_exists($imageUrl)) {
            unlink($imageUrl);
        }
    }

    // Delete the project
    $query->delete('projects', 'id = ?', [$delete_id], 'i');
    exit;
}

// project addition process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $project_name = $_POST['project_name'];
    $link = $_POST['link'];
    $description = $_POST['description'];
    $category_id = intval($_POST['category_id']);

    // Image upload process
    $uploadedImages = [];
    if (isset($_FILES['image']) && count($_FILES['image']['name']) <= 10) {
        foreach ($_FILES['image']['name'] as $i => $image_name) {
            if ($_FILES['image']['error'][$i] == 0) {
                $encrypted_name = md5(time() . $image_name) . '.' . pathinfo($image_name, PATHINFO_EXTENSION);
                $target_file = "../assets/img/projects/" . $encrypted_name;

                if (move_uploaded_file($_FILES['image']['tmp_name'][$i], $target_file)) {
                    $uploadedImages[] = $encrypted_name;
                }
            }
        }
    }

    if (!empty($uploadedImages)) {
        $query->eQuery('INSERT INTO projects (project_name, link, description, category_id) VALUES (?, ?, ?, ?)', [$project_name, $link, $description, $category_id]);
        $project_id = $query->lastInsertId();

        foreach ($uploadedImages as $uploadedImage) {
            $query->eQuery('INSERT INTO project_images (project_id, image_url) VALUES (?, ?)', [$project_id, $uploadedImage]);
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/sweetalert2-theme-bootstrap-4.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'header.php' ?>
        <div class="content-wrapper">

            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <!-- Add project Modal -->
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                data-target="#addCategoryModal">
                                Add Project
                            </button>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Project Name</th>
                                        <th>Image</th>
                                        <th>Link</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="projectTable">
                                    <?php foreach ($projects as $i => $project): ?>
                                        <tr id="project<?php echo $project['id']; ?>">
                                            <?php
                                            $projectid = $project['id'];
                                            $project_images = $query->select('project_images', '*', "Where project_id = $projectid");
                                            $project_image = "../assets/img/projects/" . $project_images[0]['image_url'];
                                            ?>
                                            <td><?php echo $i + 1; ?></td>
                                            <td><?php echo htmlspecialchars($project['project_name']); ?></td>
                                            <td><img src="<?= $project_image ?>"
                                                    alt="<?php echo htmlspecialchars($project['project_name']); ?>"
                                                    style="width: 100px;"></td>
                                            <td>
                                                <a href="<?php echo $project['link']; ?>"
                                                    style="color: #007BFF; font-weight: 600;" target="_blank">
                                                    <?php echo str_replace(['https://', 'http://'], '', $project['link']); ?>
                                                </a>
                                            </td>
                                            <td><?php echo htmlspecialchars($project['description']); ?></td>
                                            <?php $category_id = $project['category_id'] ?>
                                            <td><?php echo $query->select('category', '*', "Where id = $category_id")[0]['category_name']; ?>
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleteproject(<?php echo $projectid; ?>)">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <!-- Add Category Modal -->
                            <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
                                aria-labelledby="addCategoryLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="projectModalLabel">Add Project</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="projectForm" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <input type="hidden" name="action" value="add">
                                                <div class="form-group">
                                                    <label for="project_name">Project Name</label>
                                                    <input type="text" class="form-control" name="project_name"
                                                        id="projectName" maxlength="255" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="link">Link</label>
                                                    <input type="text" class="form-control" name="link" id="link"
                                                        maxlength="255" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" name="description"
                                                        id="projectDescription" required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="category_id">Select Category</label>
                                                    <select class="form-control" name="category_id" id="category_id"
                                                        required>
                                                        <option value="">Select Category</option>
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?php echo $category['id']; ?>">
                                                                <?php echo htmlspecialchars($category['category_name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">Upload Images (up to 10)</label>
                                                    <input type="file" class="form-control" name="image[]"
                                                        id="projectImage" accept="image/*" multiple required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include 'footer.php'; ?>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sweetalert2.min.js"></script>
    <script src="../assets/js/adminlte.min.js"></script>
    <script>
        function deleteproject(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this project!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value == true) {

                    $.ajax({
                        type: 'POST',
                        url: '',
                        data: {
                            action: 'delete',
                            delete_id: id
                        },
                        success: function (response) {
                            if (response === 'success') {
                                $('#project' + id).remove();
                                Swal.fire("Deleted!", "project deleted successfully!", "success");
                            } else {
                                Swal.fire("Error!", "An error occurred!", "error");
                            }
                        },
                        error: function () {
                            Swal.fire("Error!", "An error occurred with the AJAX request!", "error");
                        }
                    });
                }
            });
        }
    </script>

</body>

</html>