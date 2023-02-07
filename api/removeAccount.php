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
        $id = mysqli_real_escape_string($con, $id);

        $sql = "DELETE FROM users WHERE id = '$id'";
        $result = mysqli_query($con, $sql);
        if($result){
            echo 'success';
        } else {
            echo 'error';
        }
        mysqli_close($con);
    } else {
        header('Location: '.$path);
    }
?>