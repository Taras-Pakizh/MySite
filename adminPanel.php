<?php
session_start();
include 'DatabaseAction.php';
include 'Header.html';
include 'adminPanel.html';

    if(isset($_POST['Table'])){
        $_SESSION['Table'] = $_POST['Table'];
    }
    if(isset($_POST['AddSubmit'])){
        $action = new DatabaseAction();
        $row = array("Name"=>$_POST['Name'], "Lab1"=>$_POST['Lab1'], "Lab2"=>$_POST['Lab2'], "Lab3"=>$_POST['Lab3'], "Lab4"=>$_POST['Lab4'],
            "Lab5"=>$_POST['Lab5'], "Test1"=>$_POST['Test1'], "Test2"=>$_POST['Test2'], "Exam"=>$_POST['Exam']);
        $action->AddRow($row, $_SESSION['Table']);
    }
    if(isset($_POST['RemoveSubmit'])){
        $action = new DatabaseAction();
        $id = $_POST['SelectedId'];
        $action->DeleteRow($id, $_SESSION['Table']);
    }
    if(isset($_POST['ModifySubmit'])){
        $action = new DatabaseAction();
        $row = array("Name"=>$_POST['NameMod'], "Lab1"=>$_POST['Lab1Mod'], "Lab2"=>$_POST['Lab2Mod'], "Lab3"=>$_POST['Lab3Mod'], "Lab4"=>$_POST['Lab4Mod'],
            "Lab5"=>$_POST['Lab5Mod'], "Test1"=>$_POST['Test1Mod'], "Test2"=>$_POST['Test2Mod'], "Exam"=>$_POST['ExamMod'], "id"=>$_SESSION['id']);
        $action->Modify($row, $_SESSION['Table']);
    }
?>

    <body>
    <div class="container-fluid">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#AddCollapse">Add</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#RemoveCollapse">Remove</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#ModifyCollapse">Modify</button>
            </div>
        </div>
        <br>
        <div class="container-fluid collapse" id="AddCollapse" >
            <form action="adminPanel.php", name="AddForm", method="post" onsubmit="return ValidateAddForm()" class="form-inline">
                <div class="row">
                    <div class="form-group col-lg-2"><input class="form-control" type="text" name="Name" placeholder="Name" required></div>
                    <div class="form-group col-lg-1"><input class="form-control" type="number" name="Test1" placeholder="Test1" min="0" max="10"></div>
                    <div class="form-group col-lg-1"><input class="form-control" type="number" name="Test2" placeholder="Test2" min="0" max="10"></div>
                    <div class="form-group col-lg-1"><input class="form-control" type="number" name="Exam" placeholder="Exam" min="0" max="55"></div>
                    <div class="form-group col-lg-1"><input class="form-control" type="number" name="Lab1" placeholder="Lab1" min="0" max="5"></div>
                    <div class="form-group col-lg-1"><input class="form-control" type="number" name="Lab2" placeholder="Lab2" min="0" max="5"></div>
                    <div class="form-group col-lg-1"><input class="form-control" type="number" name="Lab3" placeholder="Lab3" min="0" max="5"></div>
                    <div class="form-group col-lg-1"><input class="form-control" type="number" name="Lab4" placeholder="Lab4" min="0" max="5"></div>
                    <div class="form-group col-lg-1"><input class="form-control" type="number" name="Lab5" placeholder="Lab5" min="0" max="5"></div>
                    <div class="form-group col-lg-2"><input type="submit" value="Add" class="btn btn-primary form-control" name="AddSubmit"></div>
                </div>
            </form>
        </div>
        <div class="container collapse" id="RemoveCollapse" >
            <form action="adminPanel.php", name="RemoveForm", method="post" onsubmit="return ValidateRemoveForm()" class="form-inline">
                <div class="form-group">
                    <label for="combo">Select id:</label>
                    <select class="form-control" id="combo" name="SelectedId">
                        <?php $action = new DatabaseAction(); $action->ShowIds($_SESSION['Table']); ?>
                    </select>
                    <input type="submit" name="RemoveSubmit", value="Remove", class="btn btn-primary form-control">
                </div>
            </form>
        </div>
        <div class="container collapse" id="ModifyCollapse" >
            <form action="adminPanel.php", name="ModifyForm", method="post" onsubmit="return ValidateModifyForm()" class="form-inline">
                <div class="form-group">
                    <label for="combo2">Select id:</label>
                    <select class="form-control" id="combo" name="SelectedId2">
                        <?php $action = new DatabaseAction(); $action->ShowIds($_SESSION['Table']); ?>
                    </select>
                    <input type="submit" class="btn btn-primary form-control" value="Modify selected" name="ModifyShowSubmit">
                </div>
            </form>
        </div>
        <?php
            if(isset($_POST['ModifyShowSubmit'])){
                $action = new DatabaseAction();
                $id = $_POST['SelectedId2'];
                $action->ShowModifyForm($id, $_SESSION['Table']);
                $_SESSION['id'] = $id;
            }
        ?>
    </div>
    </body>

<?php
    $action = new DatabaseAction();
    $action->OutputTable($_SESSION['Table']);
?>