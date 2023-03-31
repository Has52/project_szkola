<?php
    // session_start();
    
    if(!isset($_SESSION['username'])){
        header('Location: ' . $path);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];
        $logo = $_POST['logo'];
        $teamName = $_POST['teamName'];
        $players = $_POST['players'];

        if($logo == '' || $teamName == '' || $players == '' || $id == ''){
            echo 'error';
            return;
        }

        $con = new mysqli("localhost","root","","mecze");
        mysqli_set_charset($con, "UTF8");

        // teams table
        // teamName, teamLogo
        $sql = "UPDATE teams SET teamName = '$teamName', teamLogo = '$logo' WHERE id = $id";

        if(!mysqli_query($con, $sql)){
            echo 'error';
            return;
        }

        // players table
        // playerTeamId, playerName
        foreach($players as $player){
            $sql = "UPDATE players SET playerName = '$player' WHERE playerTeamId = $id";

            if(!mysqli_query($con, $sql)){
                echo 'error';
                return;
            }
        }


        echo 'success';

        mysqli_close($con);
    } else {
        header('Location: '.$path);
    }
?>