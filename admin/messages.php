<?php include 'check.php'; ?>

<?php
// Retrieve all messages
$messages = $query->select('messages', '*');

// If a message is 'checked', update its status
if (isset($_POST['check_message_id'])) {
    $id = $_POST['check_message_id'];
    $query->eQuery("UPDATE messages SET status = 'checked' WHERE id = ?", [$id]);
    exit(json_encode(['status' => 'success']));
}

// If delete button is clicked
if (isset($_POST['delete_message_id'])) {
    $id = $_POST['delete_message_id'];
    $query->eQuery("DELETE FROM messages WHERE id = ?", [$id]);
    exit(json_encode(['status' => 'success']));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Messages</title>
    <link href="../favicon.ico" rel="icon">
    <!-- css -->
    <?php include 'includes/css.php'; ?>
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
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/header.php' ?>
        <div class="content-wrapper">

            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <!-- Display messages -->
                        <div class="col-12">
                            <div class="card p-3 shadow-sm">

                                <?php if (count($messages) === 0): ?>
                                    <p class="no-message">No messages available.</p>
                                <?php else: ?>
                                    <ul class="list-group">
                                        <?php foreach ($messages as $message): ?>
                                            <li class="list-group-item <?php echo ($message['status'] == 'no_checked') ? 'list-group-item-warning' : ''; ?>">
                                                <strong><?php echo htmlspecialchars($message['name']); ?>:</strong>
                                                <p><?php echo htmlspecialchars($message['message']); ?></p>
                                                <small><em><?php echo htmlspecialchars($message['created_at']); ?></em></small>
                                                <div class="mt-2">
                                                    <?php if ($message['status'] == 'no_checked'): ?>
                                                        <button class="btn btn-success btn-sm check-message" data-id="<?php echo $message['id']; ?>">Checked</button>
                                                    <?php endif; ?>
                                                    <button class="btn btn-danger btn-sm delete-message" data-id="<?php echo $message['id']; ?>">Delete</button>
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

        <!-- Main Footer -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- SCRIPTS -->
    <?php include 'includes/js.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Button to mark message as 'Checked'
        $('.check-message').on('click', function() {
            var messageId = $(this).data('id');
            $.post('', {
                check_message_id: messageId
            }, function(response) {
                location.reload();
            });
        });

        // Delete message
        $('.delete-message').on('click', function() {
            var messageId = $(this).data('id');
            $.post('', {
                delete_message_id: messageId
            }, function(response) {
                location.reload();
            });
        });
    </script>
</body>

</html>