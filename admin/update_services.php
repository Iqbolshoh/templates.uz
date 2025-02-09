<?php
include 'check.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "UPDATE services SET title=?, description=? WHERE id=?";
    $params = [$title, $description, $id];

    if ($query->eQuery($sql, $params)) {
        header('Location: services.php?updated=true');
    } else {
        exit();
    }
}
