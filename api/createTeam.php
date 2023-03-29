<?php
    if(!isset($_SESSION['username'])){
        header('Location: '.$path);
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_FILES['image'])){
            $errors= array();
                    
            if($_FILES['image']['size'] > 2097152){
                $errors[]='Plik za dużo waży';
            }
                
            if(empty($errors)==true){
                $teamName = $_POST['teamName'];
                $teamImage = $_FILES['image']['name'];
                $teamPlayers = $_POST['players'];

                if(!isset($teamName) || !isset($teamImage) || !isset($teamPlayers)){
                    echo 'error';
                    return;
                }

                $con = new mysqli("localhost","root","","mecze");
                mysqli_set_charset($con, "UTF8");
                $teamName = mysqli_real_escape_string($con, $teamName);
                $teamImage = mysqli_real_escape_string($con, $teamImage);

                move_uploaded_file($_FILES['image']['tmp_name'], "images/".$_FILES['image']['name']);
                $queryTeam =  "INSERT INTO `teams` (`id`, `teamName`, `teamLogo`, `points`, `updatedAt`, `createdAt`) VALUES (NULL, '".$teamName."', '".$teamImage."', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
                $resultQueryTeam = mysqli_query($con, $queryTeam);

                foreach($teamPlayers as $row) {
                    $teamPlayerName = mysqli_real_escape_string($con, $row);
                    $queryPlayer = "INSERT INTO `players` (`id`, `playerName`, `playerTeamId`, `updatedAt`, `createdAt`) VALUES (NULL, '".$teamPlayerName."', (SELECT id FROM `teams` WHERE `teamName` = '".$teamName."' AND `teamLogo` = '".$teamImage."' LIMIT 1), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

                    $resultQueryPlayer = mysqli_query($con, $queryPlayer);
                }

                echo("ok");

                mysqli_close($con);
            }else{
                print_r($errors);
            }
        }
    }  else {
        header('Location: '.$path);
    }
?>