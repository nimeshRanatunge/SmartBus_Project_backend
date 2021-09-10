<?php
require "DataBase.php";
$db = new DataBase();
    if ($db->dbConnect()) {
        if ($db->childReg($_POST['fullname'], $_POST['username'], $_POST['gender'], $_POST['schoolcode'] ,$_POST['dob'], $_POST['doreg'], $_POST['mypar'])) {
            echo "Registration Success";
        } else echo "failed";
    } else echo "Error: Database connection";
?>
