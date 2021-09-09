<?php
require "DataBase.php";
$db = new DataBase();
    if ($db->dbConnect()) {
        if ($db->Deletingchild($_POST['childUN'])) {
            echo "Succesfully Deleted!";
        } else echo "Deletion Failed";
    } else echo "Error: Database connection";
?>
