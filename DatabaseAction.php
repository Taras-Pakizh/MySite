<?php

class DatabaseAction
{
    //Vars
    private $servername = "lab6.ua";
    private $username = "mysql";
    private $password = "mysql";
    private $dbname = "myDB";
    private $port = 3306;

    //Connect
    private function ConnectDatabase(){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    //Table
    private function GetUserTable(){
        $conn = $this->ConnectDatabase();
        $sql = "SELECT * FROM Users";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }
    private function GetAdminTable(){
        $conn = $this->ConnectDatabase();
        $sql = "SELECT * FROM Admin";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }
    private function GetSessionTable($table){
        $conn = $this->ConnectDatabase();
        $sql = "SELECT * FROM ".$table;
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }
    public function OutputTable($table){
        $table = $this->GetSessionTable($table);
        echo "<div class='container'><table class='table table-striped'><thead><tr>
            <th>Id</th>
            <th>Name</th>
            <th>Lab1</th>
            <th>Lab2</th>
            <th>Lab3</th>
            <th>Lab4</th>
            <th>Lab5</th>
            <th>Test1</th>
            <th>Test2</th>
            <th>Exam</th>
            </tr></thead><tbody>";
        while($row = $table->fetch_assoc()){
            echo "<tr><td>".$row['id']."</td><td>".$row['Name']."</td><td>".$row['Lab1']."</td><td>".$row['Lab2']."</td>
                    <td>".$row['Lab3']."</td><td>".$row['Lab4']."</td><td>".$row['Lab5']."</td>
                    <td>".$row['Test1']."</td><td>".$row['Test2']."</td><td>".$row['Exam']."</td></tr>";
        }
        echo "</tbody></div>";
    }
    private function GetIds($table){
        $conn = $this->ConnectDatabase();
        $sql = "SELECT id FROM ".$table;
        $ids = $conn->query($sql);
        $conn->close();
        return $ids;
    }
    public function ShowIds($table){
        $ids = $this->GetIds($table);
        while($id = $ids->fetch_assoc()){
            echo "<option>".$id['id']."</option>";
        }
    }
    public function ShowModifyForm($id, $table){
        echo "<div class='container-fluid'><form class='form-inline' action='adminPanel.php' method='post'><div class='row'>";
        $table = $this->GetSessionTable($table);
        while($row = $table->fetch_assoc())
            if($row['id'] == $id){
                echo "<div class='form-group col-lg-2'><input class='form-control' type='text' name='NameMod' required placeholder='Name' value='".$row['Name']."'></div>";
                echo '<div class="form-group col-lg-1"><input class="form-control" type="number" name="Test1Mod" placeholder="Test1" min="0" max="10" value="'.$row['Test1'].'"></div>';
                echo '<div class="form-group col-lg-1"><input class="form-control" type="number" name="Test2Mod" placeholder="Test2" min="0" max="10" value="'.$row['Test2'].'"></div>';
                echo '<div class="form-group col-lg-1"><input class="form-control" type="number" name="ExamMod" placeholder="Exam" min="0" max="55" value="'.$row['Exam'].'"></div>';
                echo '<div class="form-group col-lg-1"><input class="form-control" type="number" name="Lab1Mod" placeholder="Lab1" min="0" max="5" value="'.$row['Lab1'].'"></div>';
                echo '<div class="form-group col-lg-1"><input class="form-control" type="number" name="Lab2Mod" placeholder="Lab2" min="0" max="5" value="'.$row['Lab2'].'"></div>';
                echo '<div class="form-group col-lg-1"><input class="form-control" type="number" name="Lab3Mod" placeholder="Lab3" min="0" max="5" value="'.$row['Lab3'].'"></div>';
                echo '<div class="form-group col-lg-1"><input class="form-control" type="number" name="Lab4Mod" placeholder="Lab4" min="0" max="5" value="'.$row['Lab4'].'"></div>';
                echo '<div class="form-group col-lg-1"><input class="form-control" type="number" name="Lab5Mod" placeholder="Lab5" min="0" max="5" value="'.$row['Lab5'].'"></div>';
                echo '<div class="form-group col-lg-1"><input type="submit" value="Modify" class="btn btn-primary form-control" name="ModifySubmit"></div>';
                echo '<div class="form-group col-lg-1"><input type="submit" value="Hide" class="btn btn-primary form-control"></div>';
                break;
            }
        echo "</div></form></div>";
    }
    public function ShowTables($action){
        $conn = $this->ConnectDatabase();
        $sql = "SHOW TABLES";

        echo "<div class = 'container'><div class='well'>Student groups:</div>";
        if($list = $conn->query($sql)){
            while ($table = $list->fetch_row())
                if($table[0] != "Admin" && $table[0] != "Users")
                    echo "<div class='gallery'><a><img src = 'images\default.png' width='300' height='200'></a><div class='desc' style='background-color: white'><form method='post' action=".$action."><input name='Table' class='btn btn-link' type='submit' value='".$table[0]."'></form></div></div>";
        }
        else echo "Error".$conn->error;
        $conn->close();
        echo "</div>";
    }
    public function TableList(){
        $conn = $this->ConnectDatabase();
        $sql = "SHOW TABLES";
        if($list = $conn->query($sql)){
            while($table = $list->fetch_row())
                if($table[0] != "Admin" && $table[0] != "Users")
                    echo "<option>".$table[0]."</option>";
        }
        else echo "Error table list output",$conn->error;
        $conn->close();
    }
    //Sing up, Logging
    public function LoggingIn($user, $password){
        $table = $this->GetAdminTable();
        while($row = $table->fetch_assoc())
            if($row['Name'] == $user && password_verify($password, $row['Password'])){
                session_unset();
                $_SESSION['admin'] = $user;
                echo "<div class='well'><strong>Hello Admin </strong>Go to the home page</div>";
                return;
            }

        $table = $this->GetUserTable();
        while($row = $table->fetch_assoc())
            if($row['Name'] == $user) {
                if (password_verify($password, $row['Password'])) {
                    session_unset();
                    $_SESSION['user'] = $user;
                    echo "<div class='well'><strong>Welcome ".$user." </strong>You are logged in. Go to the home page</div>";
                }
                else echo "<div class='well'><strong>Wrong password </strong>Try again</div>";
                return;
            }
        echo "<div class='well'><strong>You are not singed up </strong>Go to the sing up page</div>";
    }
    public function SingUpUser($user, $password){
        //Check if there is such user
        $table = $this->GetUserTable();
        while($row = $table->fetch_assoc())
            if($row['Name'] == $user){
                echo "<div class='well'><strong>There is already user with such nickname</strong></div>";
                return;
            }
        //Sign Up
        $conn = $this->ConnectDatabase();
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Users (Name, Password) VALUES ('".$user."', '".$password."')";
        if($conn->query($sql))
            echo "<div class='well'><strong>You are signed up! </strong>Go to the home page</div>";
        else echo "<div class='well'><strong>Error: </strong>".$conn->error."</div>";
        $conn->close();
    }
    //Admin
    public function DeleteRow($id, $table){
        $conn = $this->ConnectDatabase();
        $sql = "DELETE FROM ".$table." WHERE id=".$id;

        if (!($conn->query($sql))) {
            echo "Error deleting record: " . $conn->error;
        }
        $conn->close();
    }
    public function AddRow($row, $table){
        $conn = $this->ConnectDatabase();
        $sql = "INSERT INTO ".$table." (Name, Lab1, Lab2, Lab3, Lab4, Lab5, Test1, Test2, Exam) VALUES ('".$row['Name']."', ".$row['Lab1'].", ".$row['Lab2'].", ".$row['Lab3'].", ".$row['Lab4'].", ".$row['Lab5'].", ".$row['Test1'].", ".$row['Test2'].", ".$row['Exam'].")";
        if(!($conn->query($sql))){
            echo "Error adding row ".$conn->error;
        }
        $conn->close();
    }
    public function Modify($row, $table){
        $conn = $this->ConnectDatabase();
        $sql = "UPDATE ".$table." SET Name = '".$row['Name']."', Lab1 = ".$row['Lab1'].", Lab2 = ".$row['Lab2'].", Lab3 = ".$row['Lab3'].", Lab4 = ".$row['Lab4'].", Lab5 = ".$row['Lab5'].",Test1 = ".$row['Test1'].", Test2 = ".$row['Test2'].", Exam = ".$row['Exam']." WHERE id = ".$row['id'];
        if(!($conn->query($sql))){
            echo "Error modify row ".$conn->error;
        }
        $conn->close();
    }
    public function AddTable($name){
        $conn = $this->ConnectDatabase();
        $sql  = "CREATE TABLE ".$name."(
        id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        Name varchar(30) NOT NULL,
        Lab1 int(11) NOT NULL,
        Lab2 int(11) NOT NULL,
        Lab3 int(11) NOT NULL,
        Lab4 int(11) NOT NULL,
        Lab5 int(11) NOT NULL,
        Test1 int(11) NOT NULL,
        Test2 int(11) NOT NULL,
        Exam int(11) NOT NULL
        )";

        if (!($conn->query($sql))) {
            echo "Error creating table: " . $conn->error;
        }

        $conn->close();
    }
    public function RemoveTable($name){
        $conn = $this->ConnectDatabase();
        $sql = "DROP TABLE ".$name;
        if(!($conn->query($sql)))
            echo "Error removing table: ".$conn->error;
    }
}

