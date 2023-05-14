<?php
    /*
{
            "left":{
                "points":0,
                "name": "Test Lewo",
                "logo": "./assets/testTeamLogo.png",
                "players": {
                    1: "Test Lewo 1'",
                    2: "Test Lewo 5'"
                }
            },
            "right":{
                "points":5,
                "name": "Test Prawo",
                "logo": "./assets/testTeamLogo.png",
                "players": {
                    1: "Test Lewo 1'",
                    2: "Test Lewo 5'",
                }
            }
        }
    */
    

    $con = new mysqli("localhost","root","","mecze");
    mysqli_set_charset($con, "UTF8");

    $data = $con->query('SELECT games.id, teams.teamName AS home_team, games.firstTeamId AS home_team_id, COALESCE(COUNT(CASE WHEN goals.teamId = games.firstTeamId AND goals.gameId = games.id THEN goals.id ELSE NULL END), 0) AS home_team_points, teams.teamLogo AS home_logo, t2.teamName AS away_team, games.secondTeamId AS away_team_id, COALESCE(COUNT(CASE WHEN goals.teamId = games.secondTeamId AND goals.gameId = games.id THEN goals.id ELSE NULL END), 0) AS away_team_points, t2.teamLogo AS away_team_logo, games.start AS start_time, games.end AS end_time FROM games JOIN teams ON games.firstTeamId = teams.id JOIN teams t2 ON games.secondTeamId = t2.id LEFT JOIN goals ON goals.gameId = games.id AND (goals.teamId = games.firstTeamId OR goals.teamId = games.secondTeamId) GROUP BY games.id ORDER BY games.id DESC LIMIT 1;');

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($data -> num_rows == 0){
            $matchData = new stdClass();
    
            $matchData -> left -> points = 0;
            $matchData -> right -> points = 0;
          
            $matchData -> left -> name = "Test Lewo";
            $matchData -> right -> name = "Test Prawo";
         
            $matchData -> left -> logo = "./assets/testTeamLogo.png";
            $matchData -> right -> logo = "./assets/testTeamLogo.png";
         
            $matchData -> left -> players = new stdClass();
            $matchData -> right -> players = new stdClass();
         
            $matchData -> left -> players -> {1} = "Test Lewo 1";
            $matchData -> left -> players -> {2} = "Test Lewo 2";
        
            $matchData -> right -> players -> {1} = "Test Prawo 1";
            $matchData -> right -> players -> {2} = "Test Prawo 2";
        
            $matchData -> startGame = '1678262407'; // 9:00
            $matchData -> endGame = '1678298527'; // 9:02
            
            echo(json_encode($matchData));
        } else {
            $row = $data -> fetch_assoc();

            $matchData = new stdClass();
            $matchData -> left = new stdClass();
            $matchData -> right = new stdClass();

            $matchData -> left -> points = $row['home_team_points'];
            $matchData -> right -> points = $row['away_team_points'];

            $matchData -> left -> name = $row['home_team'];
            $matchData -> right -> name = $row['away_team'];

            $matchData -> left -> logo = "./images/".$row['home_logo'];
            $matchData -> right -> logo = "./images/".$row['away_team_logo'];
        
            $matchData -> left -> players = new stdClass();
            $matchData -> right -> players = new stdClass();


            $dataPlayersTeam1 = $con->query('SELECT players.playerName FROM players RIGHT JOIN goals ON goals.playerId = players.id WHERE goals.gameId = '.$row['id'].' AND goals.teamId = '.$row['home_team_id'].' GROUP BY players.id;'); 
            $dataPlayersTeam2 = $con->query('SELECT players.playerName FROM players RIGHT JOIN goals ON goals.playerId = players.id WHERE goals.gameId = '.$row['id'].' AND goals.teamId = '.$row['away_team_id'].' GROUP BY players.id;');

            if($dataPlayersTeam1 -> num_rows == 0){
                $matchData -> left -> players -> {1} = "Brak strzelonych bramek";
            }

            if($dataPlayersTeam2 -> num_rows == 0){
                $matchData -> right -> players -> {1} = "Brak strzelonych bramek";
            }

            $i = 1;
            while($rowPlayersTeam1 = $dataPlayersTeam1 -> fetch_assoc()){
                $matchData -> left -> players -> {$i} = $rowPlayersTeam1['playerName'];
                $i++;
            }

            $i = 1;
            while($rowPlayersTeam2 = $dataPlayersTeam2 -> fetch_assoc()){
                $matchData -> right -> players -> {$i} = $rowPlayersTeam2['playerName'];
                $i++;
            }

            $matchData -> startGame = $row['start_time'];
            $matchData -> endGame = $row['end_time'];

    
            echo(json_encode($matchData));
        }
    }

?>