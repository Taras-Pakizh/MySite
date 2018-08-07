<?php
    session_start();
    include 'DatabaseAction.php';
    include 'Header.html';
    include 'mainPage.html';

    if(isset($_POST['Exit']))  session_unset();
    if(!$_SESSION['user'] && !$_SESSION['admin']) echo "<div class='container'><div class='well'>You are not logged in</div></div><div class='container'><div class='well'>This is site for working with university database. To see or modify database tables go to the page: Logging In. If you are not singed up, go to page: Sing Up.</div></div>";
    if($_SESSION['user']) echo "<div class='container'><div class='well'>Welcome ".$_SESSION[user]."</div></div>";
    if($_SESSION['admin']) echo "<div class='container'><div class='well'>Welcome admin</div></div>";

    $action = new DatabaseAction();
    if(isset($_POST['AddTable'])) $action->AddTable($_POST['TableName']);
    if(isset($_POST['RemoveTable'])) $action->RemoveTable($_POST['SelectedTable']);

    if($_SESSION['admin']){
        $actionSend='adminPanel.php';
        $action->ShowTables($actionSend);
        include 'adminIndex.php';
    }
    else if($_SESSION['user']){
        $actionSend='userPanel.php';
        $action->ShowTables($actionSend);
    }


