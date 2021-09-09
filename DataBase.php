<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    private $sql2;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;
  



    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $this->sql2 = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    function logIn($table, $username, $password)
    {
        $username = $this->prepareData(strtolower($username));
        $password = $this->prepareData($password);
        $this->sql = "select * from " . $table . " where username = '" . $username . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            if ($dbusername == $username && password_verify($password, $dbpassword)) {
                $login = true;
            } else $login = false;
        } else $login = false;

        return $login;
    }

    function signUp($fullname, $email, $username, $password, $address, $mobile)
    {
        $fullname = $this->prepareData(strtolower($fullname));
        $username = $this->prepareData(strtolower($username));
        $password = $this->prepareData($password);
        $email = $this->prepareData(strtolower($email));
        $address = $this->prepareData($address);
        $mobile = $this->prepareData($mobile);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->sql =
            "INSERT INTO users(fullname, username, password, email, address, mobile) VALUES ('$fullname','$username','$password','$email','$address','$mobile')";
        if (strlen($mobile)==10 && strpos($email, "@")== true) {
            if (mysqli_query($this->connect, $this->sql)) {
                return true;
            } else return false;
        } else return false;
    }

    function UpdatingPare($fullname, $username, $mobile, $email,$address)
    {
        $fullname = $this->prepareData(strtolower($fullname));
        $username = $this->prepareData(strtolower($username));
        $mobile = $this->prepareData($mobile);
        $email = $this->prepareData(strtolower($email));
        $address = $this->prepareData($address);
        $this->sql =
        "UPDATE users SET fullname='$fullname', mobile='$mobile', email='$email', address='$address' WHERE username='$username';";
            

        $this->sql2 = "SELECT mobile FROM users WHERE username='$username'";
        $result = mysqli_query($this->connect, $this->sql2);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            if (strlen($mobile)==10 && strpos($email, "@")== true && mysqli_query($this->connect, $this->sql2)) {
                if (mysqli_query($this->connect, $this->sql)) {
                    return true;
                } else return false;
            } else return false;
        }else return false;

       
    }
   
    function Updatingchild($childusername, $childname, $childgen, $sclcode,$childbd,$childregd)
    {
        $childusername = $this->prepareData(strtolower($childusername));
        $childname = $this->prepareData(strtolower($childname));
        $childgen = $this->prepareData(strtoupper($childgen));
        $sclcode = $this->prepareData(strtoupper($sclcode));
        $childbd = $this->prepareData($childbd);
        $childregd = $this->prepareData($childregd);
        $this->sql =
        "UPDATE children SET fullname='$childname', gender='$childgen', sclCode='$sclcode', dob='$childbd', doreg='$childregd' WHERE username='$childusername';";

        $this->sql2 = "SELECT gender FROM children WHERE username='$childusername'";
        $result = mysqli_query($this->connect, $this->sql2);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            if (mysqli_query($this->connect, $this->sql2) && ($childgen == "M" || $childgen == "F")) {
                if (mysqli_query($this->connect, $this->sql)) {
                    return true;
                } else return false;
            } else return false;
        }else return false;
    }
   

    function Deletingchild($childUN)
    {
        $childUN = $this->prepareData(strtolower($childUN));
        $this->sql =
        "DELETE FROM children WHERE username='$childUN';";
            
        $this->sql2 = "SELECT fullname FROM children WHERE username='$childUN'";
        $result = mysqli_query($this->connect, $this->sql2);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            if (mysqli_query($this->connect, $this->sql2)) {
                if (mysqli_query($this->connect, $this->sql)) {
                    return true;
                } else return false;
            } else return false;
        }else return false;
    }


    function childReg($fullname, $username, $gender, $schoolcode, $dob, $doreg, $mypar)
    {
        $fullname = $this->prepareData(strtolower($fullname));
        $mypar = $this->prepareData(strtolower($mypar));
        $username = $this->prepareData(strtolower($username));
        $gender = $this->prepareData(strtoupper($gender));
        $schoolcode = $this->prepareData(strtoupper($schoolcode));
        $dob = $this->prepareData($dob);
        $doreg = $this->prepareData($doreg);
        $this->sql =
            "INSERT INTO children(fullname, username, gender, sclCode, dob, doreg,myparentUsername) VALUES ('$fullname','$username','$gender','$schoolcode','$dob','$doreg','$mypar')";
            $this->sql2 = "SELECT fullname FROM users WHERE username='$mypar'";
            $result = mysqli_query($this->connect, $this->sql2);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) != 0) {
                if (mysqli_query($this->connect, $this->sql2)) {
                    if (mysqli_query($this->connect, $this->sql)) {
                        return true;
                    } else return false;
                } else return false;
            }else return false;
    }



    function testing($parentUN)
    {
        $childUN = $this->prepareData(strtolower($parentUN));
        $this->sql =
        "INSERT INTO test(col2) SELECT fullname FROM children WHERE myparentUsername='$parentUN'";
            
        $this->sql2 = "SELECT fullname FROM users WHERE username='$parentUN'";
        $result = mysqli_query($this->connect, $this->sql2);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            if (mysqli_query($this->connect, $this->sql2)) {
                if (mysqli_query($this->connect, $this->sql)) {
                    return true;
                } else return false;
            } else return false;
        }else return false;
    }


    
    
}


?>


