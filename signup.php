<?php
require "DataBase.php";
$db = new DataBase();
    if ($db->dbConnect()) {
        if ($db->signUp($_POST['fullname'], $_POST['email'], $_POST['username'], $_POST['password'] ,$_POST['address'], $_POST['mobile'], $_POST['gender'])) {
            echo "Sign Up Success";
        } else echo "Sign up Failed";
    } else echo "Error: Database connection";
?>
