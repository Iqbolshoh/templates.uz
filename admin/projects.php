<?php
include 'check.php';

// Fetch projects
$projects = $query->select('projects', '*');
$categories = $query->eQuery('SELECT * FROM category');


// project deletion process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Delete images
    $imagesUrl = $query->select('project_images', '*', "WHERE project_id = $delete_id");
    foreach ($imagesUrl as $image) {
        $imageUrl = "../assets/img/projects/" . $image['image_url'];
        if (file_exists($imageUrl)) {
            unlink($imageUrl);
        }
    }

    // Delete the project
    $query->eQuery('DELETE FROM projects WHERE id = ?', [$delete_id]);
    exit('success');
}

// project addition process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    // Image upload process
    $uploadedImages = [];
    $totalFiles = count($_FILES['image']['name']);
    if ($totalFiles <= 10) {
        for ($i = 0; $i < $totalFiles; $i++) {
            if ($_FILES['image']['error'][$i] == 0) {
                $image_name = basename($_FILES['image']['name'][$i]);
                $encrypted_name = md5(time() . $image_name) . "." . pathinfo($image_name, PATHINFO_EXTENSION);
                $target_dir = "../assets/img/projects/";
                $target_file = $target_dir . $encrypted_name;

                if (move_uploaded_file($_FILES['image']['tmp_name'][$i], $target_file)) {
                    $uploadedImages[] = $encrypted_name;
                }
            }
        }

        if (!empty($uploadedImages)) {
            $query->eQuery('INSERT INTO projects (project_name, description, category_id) VALUES (?, ?, ?)', [$project_name, $description, $category_id]);

            $project_id = $query->lastInsertId();

            foreach ($uploadedImages as $uploadedImage) {
                $query->eQuery('INSERT INTO project_images (project_id, image_url) VALUES (?, ?)', [$project_id, $uploadedImage]);
            }

            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } else {
        echo "Please do not upload more than 10 images.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link href="../favicon.ico" rel="icon">
    <?php include 'includes/css.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/header.php' ?>
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

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/js.php'; ?>

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