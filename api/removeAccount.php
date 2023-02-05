<?php
    session_start();
    
    if(!isset($_SESSION['username'])){
        header('Location: /');
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];
        $con = new mysqli("localhost","root","","mecze");
        $sql = "DELETE FROM users WHERE id = '$id'";
        $result = mysqli_query($con, $sql);
        if($result){
            echo 'success';
        } else {
            echo 'error';
        }
        mysqli_close($con);
    }
?>