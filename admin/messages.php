<?php
session_start();

include '../config.php';
$query = new Database();
$query->checkUserSession('admin');

// Retrieve all messages
$messages = $query->select('messages', '*');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['status' => 'error', 'message' => 'Invalid request'];

    if (isset($_POST['check_message_id'])) {
        $id = intval($_POST['check_message_id']);
        if ($id > 0) {
            $query->update('messages', ['status' => 'checked'], 'id = ?', [$id], 'i');
            $response = ['status' => 'success'];
        }
    }

    if (isset($_POST['delete_message_id'])) {
        $id = intval($_POST['delete_message_id']);
        if ($id > 0) {
            $query->delete('messages', 'id = ?', [$id], 'i');
            $response = ['status' => 'success'];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    .no-message {
        text-align: center;
        color: #ff0000;
        font-size: 20px;
        font-weight: bold;
        background-color: #f8d7da;
        padding: 15px;
        border-radius: 5px;
        margin: 20px 0;
        border: 1px solid #f5c6cb;
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include './header.php' ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-3 shadow-sm">
                                <?php if (empty($messages)): ?>
                                    <p class="no-message">No messages available.</p>
                                <?php else: ?>
                                    <ul class="list-group">
                                        <?php foreach ($messages as $message): ?>
                                            <li
                                                class="list-group-item <?php echo ($message['status'] == 'no_checked') ? 'list-group-item-warning' : ''; ?>">
                                                <strong><?php echo htmlspecialchars($message['name']); ?>:</strong>
                                                <p><?php echo htmlspecialchars($message['message']); ?></p>
                                                <small><em><?php echo htmlspecialchars($message['created_at']); ?></em></small>
                                                <div class="mt-2">
                                                    <?php if ($message['status'] == 'no_checked'): ?>
                                                        <button class="btn btn-success btn-sm check-message"
                                                            data-id="<?php echo $message['id']; ?>">Checked</button>
                                                    <?php endif; ?>
                                                    <button class="btn btn-danger btn-sm delete-message"
                                                        data-id="<?php echo $message['id']; ?>">Delete</button>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include './footer.php'; ?>
    </div>
    
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sweetalert2.min.js"></script>
    <script src="../assets/js/adminlte.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.check-message').on('click', function () {
                var messageId = $(this).data('id');
                $.post('', { check_message_id: messageId }, function (response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }, 'json');
            });

            $('.delete-message').on('click', function () {
                var messageId = $(this).data('id');
                $.post('', { delete_message_id: messageId }, function (response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }, 'json');
            });
        });
    </script>
</body>

</html>