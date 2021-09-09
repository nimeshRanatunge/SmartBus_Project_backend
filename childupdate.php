<?php
require "DataBase.php";
$db = new DataBase();
    if ($db->dbConnect()) {
        if ($db->Updatingchild($_POST['childUNU'], $_POST['childNameU'], $_POST['childGenU'], $_POST['ChildSclCodeU'] ,$_POST['childDOBu'] ,$_POST['ChildRegDateU'])) {
            echo "Succesfully updated!";
        } else echo "Updating Failed";
    } else echo "Error: Database connection";
?>
