<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mecz</title>
    <style>
        @font-face {
            font-family: San Francisco;
            font-style: normal;
            font-weight: 100;
            src: local("San Francisco"), url(https://fonts.cdnfonts.com/s/59278/SFPRODISPLAYREGULAR.woff) format("woff")
        }

        body{
            margin: 0;
            padding: 0;
            font-family: San Francisco, sans-serif;
            color: rgb(46, 45, 45);
            letter-spacing: 0.2vw;
        }
        
        #main{
            display: flex;
            width: 100vw;
            height: 100vh;
        }

        #coitainer{
            margin: auto;
            display: flex;
            width: 70%;
            height: 50%;
        }

        .matchLeftRight{
            width: 45%;
            height: 100%;
            display: flex;
        }

        .top{
            width: 10%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7vw;
            font-weight: 700;
        }
        .infoTeam{
            width: 80%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logoTeam img{
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin: auto;
            width: 15vw;
        }

        .nameTeam{
            margin-top: 10%;
            font-weight: 700;
            font-size: 2vw;
        }

        .points{
            width: 20%;
            font-size: 5vw;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .playersPoint{
            display: flex;
            letter-spacing: 0;
            flex-direction: column;
            width: 100%;
            margin-top: 5px;
        }

        .playersPoint1 > div {
            text-align: left;
        }

        .playersPoint2 > div{
            text-align: right;
        }
        
        .playersPoint1 > div, .playersPoint2 > div{
            margin-top: 10px;
        }
        
    </style>
</head>
<body>
    <div id="main">
        <div id="coitainer">
            <div class="matchLeftRight">
                <div class="infoTeam">
                    <div class="logoTeam">
                        <img src="./assets/testTeamLogo.png" alt="logo">
                    </div>
                    <div class="nameTeam">TESTOWA NAZWA</div>
                    <div class="playersPoint playersPoint1">
                        <div>Testowy Player 67'</div>
                        <div>Testowy Player 67'</div>

                    </div>
                </div>
                <div class="points">0</div>
            </div>
            <div class="top">-</div>
            <div class="matchLeftRight">
                <div class="points">0</div>
                <div class="infoTeam">
                    <div class="logoTeam">
                        <img src="./assets/testTeamLogo.png" alt="logo">
                    </div>
                    <div class="nameTeam">TESTOWA NAZWA</div>
                    <div class="playersPoint playersPoint2">
                        <div>Testowy Player 67'</div>
                        <div>Testowy Player 67'</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>