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

    $taskid = $_POST['task_id'];

    if (!isset($taskid) || empty(trim($taskid)) || !is_numeric($taskid)) {
        header("location: ../errors/400.html");
        exit();
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

    $e_task = cleanInput($task);
    $e_prio = cleanInput($_POST['priority']);

    $select = "SELECT * FROM `todo_task` WHERE id = '$taskid'";

    try {
        $res = mysqli_query($conn, $select);

        if (!mysqli_num_rows($res)) {
            header("location: ../errors/400.html");
            exit();
        }

    } catch (\Throwable $th) {
        header("location: ../errors/500.html");
        exit();
    }


    $data = mysqli_fetch_assoc($res);

    $prev_task = $data['task'];
    $prev_prio = $data['priority'];

    if ($e_task == $prev_task && $e_prio == $prev_prio) {
        setMsg("No changes made", "error", "../index.php");
    }


    $update = "UPDATE `todo_task` SET `task`='$e_task',`priority`='$e_prio',`isComplete`= false  WHERE id = '$taskid'";

    try {
        $res2 = mysqli_query($conn, $update);
    } catch (\Throwable $th) {
        header("location: ../errors/500.html");
        exit();
    }
    
    if ($res2) {
        setMsg("Task updated successfully", "success", "../index.php");
    }

}
else{
    header("location: ../errors/400.html");
}


?>