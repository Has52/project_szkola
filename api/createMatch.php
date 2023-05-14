<?php 

    if(!isset($_SESSION['username'])){
        header('Location: ' . $path);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){


        $startMatch = $_POST['startMatch'];
        $endMatch = $_POST['endMatch'];
        $team1 = $_POST['team1'];
        $team2 = $_POST['team2'];

        if(!isset($startMatch) || !isset($endMatch) || !isset($team1) || !isset($team2)){
          echo 'error';
          return;
        }

        $con = new mysqli("localhost","root","","mecze");
        mysqli_set_charset($con, "UTF8");

        $team1 = mysqli_real_escape_string($con, $team1);
        $team2 = mysqli_real_escape_string($con, $team2);
        $endMatch = mysqli_real_escape_string($con, $endMatch);
        $startMatch = mysqli_real_escape_string($con, $startMatch);


        $startMatch = date('Y-m-d H:i:s', strtotime($startMatch));
        $endMatch = date('Y-m-d H:i:s', strtotime($endMatch));

        if($team1 == $team2){
          echo 'error';
          return;
        }

        $con->query("INSERT INTO games VALUES (NULL, $team1, $team2, '$startMatch', '$endMatch', NULL, NULL)");
        echo('success');

        mysqli_close($con);

    } else {
        header('Location: '.$path);
    }

?>
