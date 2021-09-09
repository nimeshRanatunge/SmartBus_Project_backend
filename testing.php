<?php
require "DataBase.php";
$db = new DataBase();
    if ($db->dbConnect()) {
        if ($db->testing($_POST['childUN'])) {
            echo "Succesfully tested!";
        } else echo "testing Failed";
    } else echo "Error: Database connection";
?>
