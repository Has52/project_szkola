<?php
    // session_start();
    
    if(!isset($_SESSION['username'])){
        header('Location: ' . $path);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        
        if(!isset($login) || !isset($password) || strlen($password) < 6 || !isset($id)){
          echo 'error';
          return;
        }

        $con = new mysqli("localhost","root","","mecze");
        mysqli_set_charset($con, "UTF8");
        $id = mysqli_real_escape_string($con, $id);
        $login = mysqli_real_escape_string($con, $login);
        $password = mysqli_real_escape_string($con, $password);

        $sql = "UPDATE users SET login='".$login."', password=SHA1('".$password."') WHERE id=".$id."";

        $result = mysqli_query($con, $sql);

        echo 'success';

        mysqli_close($con);
    } else {
        header('Location: '.$path);
    }
?>