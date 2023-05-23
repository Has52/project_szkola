<?php
    // session_start();
    
    if(!isset($_SESSION['username'])){
        header('Location: ' . $path);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $player_id = $_POST['player_id'];
        $points = $_POST['points'];
        $match_id = $_POST['match_id'];
        $team_id = $_POST['team_id'];

        if(!isset($player_id) || !isset($points) || !isset($match_id) || !isset($team_id)){
          echo 'error';
          return;
        }

        $con = new mysqli("localhost","root","","mecze");
        mysqli_set_charset($con, "UTF8");

        $player_id = mysqli_real_escape_string($con, $player_id);
        $points = mysqli_real_escape_string($con, $points);
        $match_id = mysqli_real_escape_string($con, $match_id);
        $team_id = mysqli_real_escape_string($con, $team_id);

        for($i = 0; $i < $points; $i++){
            $con->query("INSERT INTO goals VALUES (NULL, $match_id, $team_id, $player_id, NULL, NULL, NULL)");
        }

        echo 'success';

        mysqli_close($con);
    } else {
        header('Location: '.$path);
    }
?>