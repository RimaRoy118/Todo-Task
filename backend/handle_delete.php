<?php

require_once '../db/db.php';
require '../message/setMsg.php';

if (!isset($_GET['del_id']) || empty(trim($_GET['del_id'])) || !is_numeric($_GET['del_id'])) {
    header("location: ../errors/400.html");
    exit();
}

$delid = $_GET['del_id'];

try {
    $res = mysqli_query($conn, "SELECT * FROM `todo_task` WHERE id = '$delid'");

    if (!mysqli_num_rows($res)) {
        header("location: ../errors/400.html");
        exit();
    }

} catch (\Throwable $th) {
    header("location: ../errors/500.html");
    exit();
}

$delete = "DELETE FROM `todo_task` WHERE id = '$delid'";

try {
    $res2 = mysqli_query($conn, $delete);
} catch (\Throwable $th) {
    header("location: ../errors/500.html");
    exit();
}

if ($res2) {
    setMsg("Task deleted successfully", "success", "../index.php");
}

?>