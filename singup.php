<?php
session_start();
include 'Header.html';
include 'mainPage.html';
?>

<div class="container">
    <form action="singup.php" method="post" onsubmit= "return ValidateSingUpForm('SingUp')" name="SingUp" class="form-horizontal">
        <div class="form-group">
        <input type="text" name="username" class="form-control" placeholder="User Name" required value = "<?php
            echo $_POST['username'];
        ?>">
        <input type="password" name="password" class="form-control" placeholder="Password" required value="<?php
            echo $_POST['password'];
        ?>">
        <input type="password" name="repeat" class="form-control" placeholder="Repeat password" required value="<?php
            echo $_POST['repeat'];
        ?>">
        <input type="submit" class="btn btn-default form-control" name="doLog">
        </div>
    </form>
</div>

<?php
    require 'singup.html';
    include 'DatabaseAction.php';

    if(isset($_POST['doLog'])){
        $databaseConnection = new DatabaseAction();
        $databaseConnection->SingUpUser($_POST['username'], $_POST['password']);
    }
?>
