<?php
session_start();
include 'Header.html';
include 'mainPage.html';
?>

<div class="container">
    <form action="logging.php" method="post" onsubmit= "return ValidateLoggingForm('Logging')" name="Logging">
        <div class="form-group">
        <input type="text" name="username" class="form-control" placeholder="User Name" required value="<?php
        echo $_POST[username];
        ?>">
        <input type="password" name="password" class="form-control" placeholder="Password" required value="<?php
        echo $_POST[password];
        ?>">
        <input type="submit" name="doLog" class="btn btn-default form-control" value="Log In">
        </div>
    </form>
</div>

<?php
    require 'logpage.html';
    include 'DatabaseAction.php';

    if(isset($_POST['doLog'])){
        $databaseConnection = new DatabaseAction();
        $databaseConnection->LoggingIn($_POST['username'], $_POST['password']);
    }
?>