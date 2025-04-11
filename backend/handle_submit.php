<?php

require_once '../db/db.php';
require '../message/setMsg.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!isset($_POST['task']) || !isset($_POST['priority'])) {
        header("location: ../errors/400.html");
        exit();
    }

    if (empty(trim($_POST['task'])) || empty(trim($_POST['priority']))) {
        setMsg("All fields are required", "warning", "../index.php");
    }

    $task = trim($_POST['task']);

    if (strlen($task) > 255) {
        setMsg("Task is too long", "warning", "../index.php");
    }

    function cleanInput($data)  {
        $data = trim($data);
        $data = strip_tags($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

        return $data;
    }

    $n_task = cleanInput($task);
    $priority = cleanInput($_POST['priority']);

    $insertSQL = "INSERT INTO `todo_task`(`task`, `priority`) VALUES ('$n_task','$priority')";

    try {
        $res = mysqli_query($conn, $insertSQL);
    } catch (\Throwable $th) {
        header("location: ../errors/500.html");
        exit();
    }

    if ($res) {
        setMsg("Task added successfully", "success", "../index.php");
    }
}
else{
    header("location: ../errors/400.html");
}


?>