<?php
require "DataBase.php";
$db = new DataBase();
    if ($db->dbConnect()) {
        if ($db->UpdatingPare("users", $_POST['fullname'], $_POST['username'], $_POST['mobile'], $_POST['email'] ,$_POST['address'])) {
            echo "Succesfully updated!";
        } else echo "Updating Failed";
    } else echo "Error: Database connection";
?>
