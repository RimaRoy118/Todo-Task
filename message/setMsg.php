<?php

session_start();

function setMsg($msg, $msg_type, $location)  {
    $_SESSION['message'] = $msg;
    $_SESSION['type'] = $msg_type;
    header("location: $location");
    exit();
}


?>