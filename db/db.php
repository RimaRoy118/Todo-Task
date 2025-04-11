<?php

try {
    $conn = mysqli_connect("localhost", "root", "", "rima");
} catch (\Throwable $th) {
    header("location: /PHP/Todo%20App/errors/500.html");
    exit();
}

?>