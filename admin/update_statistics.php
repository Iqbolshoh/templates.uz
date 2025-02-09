<?php
include 'check.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $count = $_POST['count'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "UPDATE statistics SET count=?, title=?, description=? WHERE id=?";
    $params = [$count, $title, $description, $id];

    if ($query->eQuery($sql, $params)) {
        header('Location: statistics.php?updated=true');
    } else {
        header('Location: statistics.php?updated=false');
    }
    exit();
}
