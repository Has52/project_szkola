<?php
    // session_start();
    
    if(!isset($_SESSION['username'])){
        header('Location: '.$path);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];

        if(!isset($id)){
            echo 'error';
            return;
        }

        $con = new mysqli("localhost","root","","mecze");
        mysqli_set_charset($con, "UTF8");
        $id = mysqli_real_escape_string($con, $id);

        $result = mysqli_query($con, "DELETE FROM teams WHERE id = '$id'");
        $result2 = mysqli_query($con, "DELETE FROM players WHERE playerTeamId = '$id'");

        if($result && $result2){
            echo 'success';
        } else {
            echo 'error';
        }
        mysqli_close($con);
    } else {
        header('Location: '.$path);
    }
?>