<?php include 'check.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $icon = $_POST['icon'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "UPDATE features SET title=?, description=? WHERE id=?";
    $query->eQuery($sql, [$title, $description, $id]);

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

$editFeature = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editFeature = $query->select('features', '*', "WHERE id = {$id}")[0];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Features</title>
    <link href="../favicon.ico" rel="icon">
    <?php include 'includes/css.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/header.php' ?>
        <div class="content-wrapper">

            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch data from features table
                                    $features = $query->select('features', '*');
                                    $i = 1;
                                    foreach ($features as $index => $feature) {
                                        $index++;
                                        echo "<tr>";
                                        echo "<td>{$index}</td>";
                                        echo "<td>" . htmlspecialchars($feature['title'], ENT_QUOTES, 'UTF-8') . "</td>";
                                        echo "<td>" . htmlspecialchars($feature['description'], ENT_QUOTES, 'UTF-8') . "</td>";
                                        echo "<td>
                                            <a href='#' class='btn btn-warning' data-id='{$feature['id']}' data-title='" . htmlspecialchars($feature['title'], ENT_QUOTES, 'UTF-8') . "' data-description='" . htmlspecialchars($feature["description"], ENT_QUOTES, 'UTF-8') . "' data-icon='{$feature['icon']}'>Edit</a>
                                        </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Modal -->
            <div class="modal fade" id="editFeatureModal" tabindex="-1" role="dialog"
                aria-labelledby="editFeatureModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editFeatureModalLabel">Edit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="" id="editFeatureForm">
                                <input type="hidden" name="id" id="editId" value="">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" name="title" id="editTitle" class="form-control" maxlength="255"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea name="description" id="editDescription" class="form-control"
                                        required></textarea>
                                </div>
                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Main Footer -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- SCRIPTS -->
    <?php include 'includes/js.php'; ?>

    <script>
        // Open modal when the edit button is clicked
        $(document).ready(function () {
            $('.btn-warning').click(function (e) {
                e.preventDefault();

                // Fill the modal
                var id = $(this).data('id');
                var title = $(this).data('title');
                var description = $(this).data('description');
                var icon = $(this).data('icon');

                // Fill the modal fields
                $('#editId').val(id);
                $('#editTitle').val(title);
                $('#editDescription').val(description);

                // Show the modal
                $('#editFeatureModal').modal('show');
            });
        });
    </script>
</body>

</html>