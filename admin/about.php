<?php include 'check.php';

$old_image_path = "../" . $query->select("about", "*")[0]['image'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_about'])) {

        $id = $_POST['id'];
        $title = $_POST['title'];
        $p1 = $_POST['p1'];
        $p2 = $_POST['p2'];
        $image = $_FILES['image']['name'];

        $sql = "SELECT image FROM about WHERE id=?";
        $result = $query->eQuery($sql, [$id]);

        if ($image) {
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }

            $new_image_name = uniqid() . '-' . basename($image);
            $target_path = "../assets/img/$new_image_name";

            move_uploaded_file($_FILES['image']['tmp_name'], $target_path);

            $sql = "UPDATE about SET title=?, p1=?, p2=?, image=? WHERE id=?";
            $query->eQuery($sql, [$title, $p1, $p2, 'assets/img/' . $new_image_name, $id]);
        } else {
            $sql = "UPDATE about SET title=?, p1=?, p2=? WHERE id=?";
            $query->eQuery($sql, [$title, $p1, $p2, $id]);
        }

        header('Location: about.php?updated=true');
        exit();
    } elseif (isset($_POST['update_ul_items'])) {
        $ul_item_id = $_POST['ul_item_id'];
        $list_item = $_POST['list_item'];

        $sql = "UPDATE about_ul_items SET list_item=? WHERE id=?";
        $query->eQuery($sql, [$list_item, $ul_item_id]);

        header('Location: about.php?updated=true');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>About Us</title>
    <link href="../favicon.ico" rel="icon">
    <?php include 'includes/css.php'; ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/header.php' ?>
        <div class="content-wrapper">

            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">

                            <!-- Data from 'about' table -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Title</th>
                                        <th>Comment</th>
                                        <th>Paragraph</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetching data from 'about' table
                                    $aboutItems = $query->select('about', '*');

                                    // Creating a row for each 'about' item
                                    foreach ($aboutItems as $item) {
                                        echo "<tr>";
                                        echo "<td>{$item['id']}</td>";
                                        echo "<td>{$item['title']}</td>";
                                        echo "<td>{$item['p1']}</td>";
                                        echo "<td>{$item['p2']}</td>";
                                        echo "<td><img src='../{$item['image']}' alt='Image' style='width: 100px; height: auto;'></td>";
                                        echo "<td>
                                            <button class='btn btn-warning' data-toggle='modal' data-target='#editAboutModal' data-id='{$item['id']}'>Edit</button>
                                        </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editAboutModal" tabindex="-1" role="dialog"
                                aria-labelledby="editAboutModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editAboutModalLabel">Edit About</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editAboutForm" method="POST" action=""
                                                enctype="multipart/form-data">
                                                <input type="hidden" name="id" id="editAboutId">
                                                <div class="form-group">
                                                    <label for="title">Title:</label>
                                                    <input type="text" name="title" id="editAboutTitle"
                                                        class="form-control" required maxlength="255">
                                                </div>
                                                <div class="form-group">
                                                    <label for="p1">P1:</label>
                                                    <textarea name="p1" id="editAboutP1" class="form-control"
                                                        required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="p2">P2:</label>
                                                    <textarea name="p2" id="editAboutP2" class="form-control"
                                                        required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">Image:</label>
                                                    <input type="file" name="image" class="form-control"
                                                        accept="image/*">
                                                </div>
                                                <button type="submit" name="update_about"
                                                    class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h2 class="m-0">About UL Items</h2>

                            <!-- Data from 'about_ul_items' table -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>List Item</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetching data from 'about_ul_items' table
                                    $ulItems = $query->select('about_ul_items', '*');

                                    // Creating a row for each UL item
                                    foreach ($ulItems as $ulItem) {
                                        echo "<tr>";
                                        echo "<td>{$ulItem['id']}</td>";
                                        echo "<td>{$ulItem['list_item']}</td>";
                                        echo "<td>
                                            <button class='btn btn-warning' data-toggle='modal' data-target='#editUlItemModal' data-id='{$ulItem['id']}'>Edit</button>
                                        </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- Edit UL Item Modal -->
                            <div class="modal fade" id="editUlItemModal" tabindex="-1" role="dialog"
                                aria-labelledby="editUlItemModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUlItemModalLabel">Edit UL Item</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editUlItemForm" method="POST" action="">
                                                <input type="hidden" name="ul_item_id" id="editUlItemId">
                                                <div class="form-group">
                                                    <label for="list_item">List Item:</label>
                                                    <textarea name="list_item" id="editUlItemList" class="form-control"
                                                        required></textarea>
                                                </div>
                                                <button type="submit" name="update_ul_items"
                                                    class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
    <?php include 'includes/js.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // For the 'About' edit modal
        $('#editAboutModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id');

            // Get other required data
            var title = button.closest('tr').find('td:eq(1)').text();
            var p1 = button.closest('tr').find('td:eq(2)').text();
            var p2 = button.closest('tr').find('td:eq(3)').text();

            var modal = $(this);
            modal.find('#editAboutId').val(id);
            modal.find('#editAboutTitle').val(title);
            modal.find('#editAboutP1').val(p1);
            modal.find('#editAboutP2').val(p2);
        });

        // For the 'UL Item' edit modal
        $('#editUlItemModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id');
            var list_item = button.closest('tr').find('td:eq(1)').text();

            var modal = $(this);
            modal.find('#editUlItemId').val(id);
            modal.find('#editUlItemList').val(list_item);
        });
    </script>

</body>

</html>