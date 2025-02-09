<?php
include 'check.php';

// Old image path for the bioServices
$old_image_path = "../assets/img/" . $query->select("bioServices", "*")[0]['image'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Update for bioServices
        if (isset($_POST['update_bio_services'])) {
            $id = $_POST['id'];
            $h2 = $_POST['h2'];
            $p1 = $_POST['p1'];
            $h3 = $_POST['h3'];
            $p2 = $_POST['p2'];
            $image = $_FILES['image']['name'];

            $sql = "SELECT image FROM bioServices WHERE id=?";
            $result = $query->eQuery($sql, [$id]);

            if ($image) {
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }

                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $image_extension = pathinfo($image, PATHINFO_EXTENSION);

                if (!in_array($image_extension, $allowed_extensions)) {
                    throw new Exception("Invalid image extension.");
                }

                $new_image_name = uniqid() . '-' . basename($image);
                $target_path = "../assets/img/$new_image_name";

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    throw new Exception("Error occurred during image upload.");
                }

                $sql = "UPDATE bioServices SET h2=?, p1=?, image=?, h3=?, p2=? WHERE id=?";
                $query->eQuery($sql, [$h2, $p1, $new_image_name, $h3, $p2, $id]);
            } else {
                $sql = "UPDATE bioServices SET h2=?, p1=?, h3=?, p2=? WHERE id=?";
                $query->eQuery($sql, [$h2, $p1, $h3, $p2, $id]);
            }

            header('Location: ourServices.php?updated=true');
            exit();
        }

        // Update for ourServices
        if (isset($_POST['update_our_services'])) {
            $id = $_POST['id'];
            $service_name = $_POST['service_name'];
            $skill_level = $_POST['skill_level'];

            $sql = "UPDATE ourServices SET service_name=?, skill_level=? WHERE id=?";
            $query->eQuery($sql, [$service_name, $skill_level, $id]);

            header('Location: ourServices.php?updated=true');
            exit();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Our Services</title>
    <link href="../favicon.ico" rel="icon">
    <!-- css -->
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

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Title</th>
                                        <th>Comment</th>
                                        <th>Subtitle</th>
                                        <th>Paragraph</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $bioServices = $query->select('bioServices'); // Fetching data from 'bioServices' table
                                    foreach ($bioServices as $service) {
                                        echo "<tr>";
                                        echo "<td>{$service['id']}</td>"; // ID
                                        echo "<td>{$service['h2']}</td>"; // Title
                                        echo "<td>{$service['p1']}</td>"; // Comment
                                        echo "<td>{$service['h3']}</td>"; // Subtitle
                                        echo "<td>{$service['p2']}</td>"; // Paragraph
                                        echo "<td><img src='../assets/img/{$service['image']}' alt='{$service['h2']}' style='width: 100px; height: auto;'></td>"; // Image
                                        ?>
                                        <td>
                                            <button class="btn btn-warning edit-service"
                                                data-id="<?php echo $service['id']; ?>"
                                                data-h2="<?php echo htmlspecialchars($service['h2'], ENT_QUOTES); ?>"
                                                data-p1="<?php echo htmlspecialchars($service['p1'], ENT_QUOTES); ?>"
                                                data-h3="<?php echo htmlspecialchars($service['h3'], ENT_QUOTES); ?>"
                                                data-p2="<?php echo htmlspecialchars($service['p2'], ENT_QUOTES); ?>"
                                                data-image="<?php echo htmlspecialchars($service['image'], ENT_QUOTES); ?>">
                                                Edit
                                            </button>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- Our Services Table -->
                            <h3>Our Services List</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Service Name</th>
                                        <th>Skill Level</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ourServices = $query->select('ourServices'); // Fetching data from 'ourServices' table
                                    foreach ($ourServices as $service) {
                                        echo "<tr>";
                                        echo "<td>{$service['id']}</td>"; // Service id
                                        echo "<td>{$service['service_name']}</td>"; // Service Name
                                        echo "<td>{$service['skill_level']}</td>"; // Skill Level
                                        echo "<td>
                                            <button class='btn btn-warning edit-our-service' ourServices-id='{$service['id']}' serviceName='{$service['service_name']}' skillLevel='{$service['skill_level']}'>Edit</button>
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
        </div>

        <!-- Main Footer -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="service-id" required>

                        <div class="form-group">
                            <label for="h2">Title:</label>
                            <input type="text" class="form-control" name="h2" id="h2" placeholder="Enter the title"
                                maxlength="255" required>
                        </div>

                        <div class="form-group">
                            <label for="p1">Comment:</label>
                            <textarea class="form-control" name="p1" id="p1" placeholder="Enter the comment"
                                required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="h3">Additional Title:</label>
                            <input type="text" class="form-control" name="h3" id="h3"
                                placeholder="Enter additional title" required>
                        </div>

                        <div class="form-group">
                            <label for="p2">Additional Paragraph:</label>
                            <textarea class="form-control" name="p2" id="p2" placeholder="Enter additional paragraph"
                                required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" name="update_bio_services">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Services Edit Modal -->
    <div class="modal fade" id="editOurServiceModal" tabindex="-1" role="dialog"
        aria-labelledby="editOurServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOurServiceModalLabel">Edit Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="editServiceForm">
                        <input type="hidden" name="id" id="our-service-id" value="">
                        <div class="form-group">
                            <label for="service_name">Service Name:</label>
                            <input type="text" class="form-control" name="service_name" id="service_name"
                                maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="skill_level">Skill Level:</label>
                            <input type="text" class="form-control" name="skill_level" id="skill_level" maxlength="2"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update_our_services">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php include 'includes/js.php'; ?>

    <script>
        document.querySelectorAll('.edit-our-service').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('ourServices-id');
                const serviceName = button.getAttribute('serviceName');
                const skillLevel = button.getAttribute('skillLevel');

                document.getElementById('our-service-id').value = id;
                document.getElementById('service_name').value = serviceName;
                document.getElementById('skill_level').value = skillLevel;

                $('#editOurServiceModal').modal('show');
            });
        });

        document.querySelectorAll('.edit-service').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const h2 = button.getAttribute('data-h2');
                const p1 = button.getAttribute('data-p1');
                const image = button.getAttribute('data-image');
                const h3 = button.getAttribute('data-h3');
                const p2 = button.getAttribute('data-p2');

                document.getElementById('service-id').value = id;
                document.getElementById('h2').value = h2;
                document.getElementById('p1').value = p1;
                document.getElementById('h3').value = h3;
                document.getElementById('p2').value = p2;

                if (image) {
                    document.getElementById('image').setAttribute('data-image-url', image);
                }

                $('#editServiceModal').modal('show');
            });
        });
    </script>

</body>

</html>