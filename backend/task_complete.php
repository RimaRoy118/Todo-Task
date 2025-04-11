<?php

require_once '../db/db.php';
require '../message/setMsg.php';

if (!isset($_GET['com_id']) || empty(trim($_GET['com_id'])) || !is_numeric($_GET['com_id'])) {
    header("location: ../errors/400.html");
    exit();
}

$comid = $_GET['com_id'];

try {
    $res = mysqli_query($conn, "SELECT * FROM `todo_task` WHERE id = '$comid' AND isComplete = false");

    if (!mysqli_num_rows($res)) {
        header("location: ../errors/400.html");
        exit();
    }

} catch (\Throwable $th) {
    header("location: ../errors/500.html");
    exit();
}

$update = "UPDATE `todo_task` SET `isComplete`= true WHERE id = '$comid'";

try {
    $res2 = mysqli_query($conn, $update);
} catch (\Throwable $th) {
    header("location: ../errors/500.html");
    exit();
}

if ($res2) {
    setMsg("Task completed successfully", "success", "../index.php");
}

?>