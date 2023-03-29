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
    
    $matchData = new stdClass();
    $matchData -> left = new stdClass();
    $matchData -> right = new stdClass();

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

    // if(!isset($_SESSION['username'])){
    //     header('Location: ' . $path);
    // }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        echo(json_encode($matchData));
    }

?>