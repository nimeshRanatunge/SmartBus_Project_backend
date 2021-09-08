<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;
  



    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
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
        $username = $this->prepareData($username);
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

    function signUp($table, $fullname, $email, $username, $password, $address, $mobile)
    {
        $fullname = $this->prepareData($fullname);
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $email = $this->prepareData($email);
        $address = $this->prepareData($address);
        $mobile = $this->prepareData($mobile);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->sql =
            "INSERT INTO " . $table . " (fullname, username, password, email, address, mobile) VALUES ('" . $fullname . "','" . $username . "','" . $password . "','" . $email . "','" . $address . "','" . $mobile . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }

    function UpdatingPare($table, $fullname, $username, $mobile, $email,$address)
    {
        $fullname = $this->prepareData($fullname);
        $username = $this->prepareData($username);
        $mobile = $this->prepareData($mobile);
        $email = $this->prepareData($email);
        $address = $this->prepareData($address);
        $this->sql =
        "UPDATE ".$table." SET fullname='$fullname', mobile='$mobile', email='$email', address='$address' WHERE username='$username';";
            
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }
   
    function Updatingchild($table, $childid, $childname, $childgen, $sclcode,$childbd,$childregd)
    {
        $childid = $this->prepareData($childid);
        $childname = $this->prepareData($childname);
        $childgen = $this->prepareData($childgen);
        $sclcode = $this->prepareData($sclcode);
        $childbd = $this->prepareData($childbd);
        $childregd = $this->prepareData($childregd);
        $this->sql =
        "UPDATE ".$table." SET fullname='$childname', gender='$childgen', sclCode='$sclcode', dob='$childbd', doreg='$childregd' WHERE id='$childid';";
            
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }
   

    function Deletingchild($table, $childUN)
    {
        $childUN = $this->prepareData($childUN);
        $this->sql =
        "DELETE FROM ".$table." WHERE username='$childUN';";
            
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }



    function childReg($table, $fullname, $username, $gender, $schoolcode, $dob, $doreg)
    {
        $fullname = $this->prepareData($fullname);
        $username = $this->prepareData($username);
        $gender = $this->prepareData($gender);
        $schoolcode = $this->prepareData($schoolcode);
        $dob = $this->prepareData($dob);
        $doreg = $this->prepareData($doreg);
        $this->sql =
            "INSERT INTO " . $table . " (fullname, username, gender, sclCode, dob, doreg) VALUES ('" . $fullname . "','" . $username . "','" . $gender . "','" . $schoolcode . "','" . $dob . "','" . $doreg . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }

    
    
}

?>


