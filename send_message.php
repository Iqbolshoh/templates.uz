<?php
include './config.php';
$query = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $query->validate($_POST['name']);
    $email = $query->validate($_POST['email']);
    $subject = $query->validate($_POST['subject']);
    $message = $query->validate($_POST['message']);

    $data = [
        'name' => $name,
        'email' => $email,
        'subject' => $subject,
        'message' => $message
    ];

    $result = $query->insert('messages', $data);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Your message has been sent. Thank you!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while sending the message.']);
    }
}
