<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mecz</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            display: block;
            letter-spacing: 0;
            margin-top: 5px;
            width: 100%;
            height: calc(100%/3);
        }
        
        .playersPoint1 > span, .playersPoint2 > span{
            margin-right: 5px;
            padding: 3px;
            font-size: 0.9vw;
        }

        #gameTime{
            position: fixed;
            font-size: 3vw;
            top: 20%;
        }

        .logoTeam{
            width: 100%;
            height: 100%;
        }
        
    </style>
</head>
<body>
    <div id="main">
        <div id="coitainer">
            <div class="matchLeftRight">
                <div class="infoTeam">
                    <div class="logoTeam">
                        <img src="" alt="logo" id='leftLogo'>
                    </div>
                    <div class="nameTeam" id='leftName'></div>
                    <div class="playersPoint playersPoint1" id='leftPlayers'>
                        <!-- <div>Testowy Player 67'</div> -->
                        <!-- <div>Testowy Player 67'</div> -->
                    </div>
                </div>
                <div class="points" id='leftPoints'>0</div>
            </div>
            <div class="top">
                <div>-</div>
                <div id="gameTime"></div>
            </div>
            <div class="matchLeftRight">
                <div class="points" id='rightPoints'>0</div>
                <div class="infoTeam">
                    <div class="logoTeam">
                        <img src="" alt="logo" id='rightLogo'>
                    </div>
                    <div class="nameTeam" id='rightName'></div>
                    <div class="playersPoint playersPoint2" id='rightPlayers'>
                        <!-- <div>Testowy Player 67',</div> -->
                        <!-- <div>Testowy Player 67'</div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let leftPlayers = document.getElementById('leftPlayers')
        let rightPlayers = document.getElementById('rightPlayers')
        let startTime = 0;
        let endTime = 0;

        let updateTime = () => {
            const now = Math.floor(Date.now() / 1000);
            const elapsedSeconds = now - startTime;
            const elapsedMinutes = Math.floor(elapsedSeconds / 60);
            const elapsedSecondsInMinute = elapsedSeconds % 60;

            if(endTime < now || (startTime == 0 && endTime == 0)) {
                document.getElementById('gameTime').innerHTML = startTime == 0 ? `Ładowanie...` : 'KONIEC'
                return
            };

            let minutes = elapsedMinutes <= 9 ? `0${elapsedMinutes}` : elapsedMinutes
            let seconds = elapsedSecondsInMinute <= 9 ? `0${elapsedSecondsInMinute}` : elapsedSecondsInMinute

            document.getElementById('gameTime').innerHTML = `${minutes}:${seconds}`
        }
        

        let updateMatch = () => {
            $.ajax({
				type: 'POST',
				url: './api/match.php',
				success: function(data) {
                    // console.log(data);
                    data = JSON.parse(data);
                    $('#rightPoints').text(data.right.points);
                    $('#leftPoints').text(data.left.points);
                    $('#rightName').text(data.right.name);
                    $('#leftName').text(data.left.name);
                    $('#leftLogo').attr("src", data.left.logo);
                    $('#rightLogo').attr("src", data.right.logo);

                    leftPlayers.innerHTML = '';
                    rightPlayers.innerHTML = '';

                    Object.entries(data.left.players).forEach(element => {
                        let elementDiv = document.createElement('span');
                        elementDiv.innerText = element[1] + ',';
                        leftPlayers.appendChild(elementDiv)
                    });

                    Object.entries(data.right.players).forEach(element => {
                        let elementDiv = document.createElement('span');
                        elementDiv.innerText = element[1] + ',';
                        rightPlayers.appendChild(elementDiv)
                    });

                    startTime = data.startGame;
                    endTime = data.endGame;
				},
				error: function(xhr, status, error) {
					console.log(error);
				}
			});
        }

        setInterval(updateMatch, 1000);
        setInterval(updateTime, 1000);
    </script>
</body>
</html>