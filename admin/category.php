<?php
session_start();

include '../config.php';
$query = new Database();
$query->checkUserSession('admin');

// Select Category
$categories = $query->eQuery('SELECT 
    c.id,
    c.category_name, 
    COUNT(p.id) AS project_count
FROM 
    category c
LEFT JOIN 
    projects p ON c.id = p.category_id
GROUP BY 
    c.id, c.category_name;
');

// Add Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add' && isset($_POST['category_name'])) {
    $category_name = $_POST['category_name'];
    $query->eQuery('INSERT INTO category (category_name) VALUES (?)', [$category_name]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Update Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $category_name = $_POST['category_name'];
    $query->eQuery('UPDATE category SET category_name = ? WHERE id = ?', [$category_name, $id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Delete Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    $projectIds = $query->select('projects', 'id', "WHERE category_id = $delete_id");

    foreach ($projectIds as $project) {
        $projectId = $project['id'];
        $imagesUrl = $query->select('project_images', '*', "WHERE project_id = $projectId");
        foreach ($imagesUrl as $image) {
            $imageUrl = "../assets/img/projects/" . $image['image_url'];
            if (file_exists($imageUrl)) {
                unlink($imageUrl);
            }
        }
    }
    $query->eQuery('DELETE FROM category WHERE id = ?', [$delete_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
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
        <?php include 'includes/header.php'; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Add Category Button -->
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                data-target="#addCategoryModal" id="addCategoryLabel">
                                Add Category
                            </button>

                            <!-- Add Category Modal -->
                            <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
                                aria-labelledby="addCategoryLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addCategoryLabel">Add Category</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="POST">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="category_name">Category Name</label>
                                                    <input type="text" class="form-control" name="category_name"
                                                        maxlength="255" required>
                                                    <input type="hidden" name="action" value="add">
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

                            <!-- Category Table -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Categories</th>
                                        <th>Projects Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $index => $category): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo htmlspecialchars($category['category_name'], ENT_QUOTES, 'UTF-8'); ?>
                                            </td>
                                            <td><?php echo $category['project_count'] ?? 0; ?></td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#editModal<?php echo $category['id']; ?>">Edit</button>

                                                <!-- Delete Button -->
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleteCategory(<?php echo $category['id']; ?>);">Delete</button>
                                            </td>
                                        </tr>

                                        <!-- Edit Category Modal -->
                                        <div class="modal fade" id="editModal<?php echo $category['id']; ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="editLabel<?php echo $category['id']; ?>"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editLabel<?php echo $category['id']; ?>">Edit Category</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="" method="POST">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="category_name">Category Name</label>
                                                                <input type="text" class="form-control" name="category_name"
                                                                    value="<?php echo htmlspecialchars($category['category_name'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                    maxlength="255" required>
                                                                <input type="hidden" name="action" value="edit">
                                                                <input type="hidden" name="id"
                                                                    value="<?php echo $category['id']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-warning">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sweetalert2.min.js"></script>
    <script src="../assets/js/adminlte.min.js"></script>
    <script>
        function deleteCategory(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this category!",
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
                            Swal.fire("Deleted!", "Category deleted successfully!", "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            Swal.fire("Error!", "There was an error deleting the category.", "error");
                        }
                    });
                }
            });
        }
    </script>
</body>

</html>