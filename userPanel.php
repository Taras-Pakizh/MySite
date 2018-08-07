<?php
session_start();
include 'DatabaseAction.php';
include 'Header.html';
include "adminPanel.html";

    if(isset($_POST['Table'])){
        $_SESSION['Table'] = $_POST['Table'];
    }
    if($_SESSION['user']) {
        $action = new DatabaseAction();
        $action->OutputTable($_SESSION['Table']);
    }

?>