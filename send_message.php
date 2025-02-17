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
        echo json_encode(['status' => 'success', 'message' => 'Xabaringiz yuborildi. Rahmat!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Xabar yuborishda xatolik yuz berdi.']);
    }
}
