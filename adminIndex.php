<?php
    session_start();
    include 'mainPage.html';
?>

<script src="script.js"></script>
<hr>
<div class="container">
    <form class="form-inline" method="post" action="index.php" onsubmit="return ValidateAddTable()" name="ff">
        <div class="form-group">
            <input type="submit" name="AddTable" class="form-control btn btn-primary" value="Add Table">
            <input type="text" name="TableName" class="form-control">
        </div>
    </form>
    <form class="form-inline" method="post" action="index.php" onsubmit="return ValidateRemoveTable()">
        <div class="form-group">
            <input type="submit" name="RemoveTable" class="form-control btn btn-primary" value="Remove Table">
            <select class="form-control" name="SelectedTable">
                <?php
                $action->TableList();
                ?>
            </select>
        </div>
    </form>
</div>