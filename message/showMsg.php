<?php

session_start();

if (isset($_SESSION['message'])) {
    echo "<div class='popMsg {$_SESSION['type']}'>
        <span>{$_SESSION['message']}</span>
        </div>";
    
    unset($_SESSION['message']);
    unset($_SESSION['type']);
}

?>