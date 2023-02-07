<?php
    // session_start();
    
    if(!isset($_SESSION['username'])){
        header('Location: ' . $path);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $login = $_POST['login'];
        $password = $_POST['password'];
        
        if(!isset($login) || !isset($password) || strlen($password) < 6){
          echo 'error';
          return;
        }

        $con = new mysqli("localhost","root","","mecze");
        $login = mysqli_real_escape_string($con, $login);
        $password = mysqli_real_escape_string($con, $password);

        $sql = "INSERT INTO users (login, password) VALUES ('".$login."', SHA1('".$password."'))";

        $result = mysqli_query($con, $sql);

        echo 'success';

        mysqli_close($con);
    } else {
        header('Location: '.$path);
    }
?>