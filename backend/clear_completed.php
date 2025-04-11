<?php

require_once '../db/db.php';
require '../message/setMsg.php';


$delete = "DELETE FROM `todo_task` WHERE isComplete = true";

try {
    $res2 = mysqli_query($conn, $delete);
} catch (\Throwable $th) {
    header("location: ../errors/500.html");
    exit();
}

if ($res2) {
    setMsg("All completed task deleted successfully", "success", "../index.php");
}

?>