<div id='component'>
    <div id="titleComponent">Dodaj Mecz</div>
    <div id="contenerContent">
        <div id="upperContent">
            <div class="lr">
                <div class="logoLr">
                    <img src="./images/mucka.png" alt="x" id='teamLogo1'>
                </div>
                <div class="selectMenu">
                    <div class="titleSelectMenu">Wybierz Drużynę 1</div>
                    <select name="team1" id="team1">

                    </select>
                </div>
            </div>
            <div class="lr">
                <div class="logoLr">
                    <img src="./images/mucka.png" alt="x" id='teamLogo2'>
                </div>
                <div class="selectMenu">
                    <div class="titleSelectMenu">Wybierz Drużynę 2</div>
                    <select name="team2" id="team2">

                    </select>
                </div>
            </div>
        </div>
        <div id="leftContent">
            <div id="button" style='right: auto; padding: 10px 20px;' onclick='createMetch()'>Stwórz mecz</div>
        </div>
    </div>
</div>

<style>
    #upperContent{
        display: flex;
        width: 100%;
        height: 90%;
    }

    #leftContent{
        display: flex;
        width: 100%;
        height: 10%;
    }

    .lr{
        width: 50%;
        height: 100%; 
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    #button{
        width: fit-content;
        padding: 10px 20px;
        background: rgba(46, 49, 236, 0.863);
        background: linear-gradient(35deg, rgb(10, 137, 211) 0%, rgb(5, 194, 241) 35%, rgba(0,212,255,1) 100%);
        color: white;
        border-radius: 10px;
        cursor: pointer;
        height: fit-content;
    }

    .logoLr{
        width: 100%;
        height: 70%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .selectMenu{
        width: 100%;
        height: 30%;
        text-align: center;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        align-content: center;
        align-items: center;
    }

    .selectMenu select {
        width: 50%;
    }

    .logoLr img {
        width: 6vw;
    }

    .titleSelectMenu{
        font-size: 1.3vw;
        font-weight: 600;
        letter-spacing: 0.125rem;
        text-transform: uppercase;
        background: rgb(46,101,236);
        background: linear-gradient(35deg, rgb(10, 137, 211) 0%, rgb(5, 194, 241) 35%, rgba(0,212,255,1) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        height: 50%;
    }

</style>

<script>
    <?php
        $teams = $con->query('SELECT * FROM teams');
        echo('let teams = '.json_encode($teams->fetch_all(MYSQLI_ASSOC)));
    ?>

    let team1 = document.getElementById('team1');
    let team2 = document.getElementById('team2');

    teams.forEach((element, i) => {
        let option = document.createElement('option');
        option.value = element.id;
        option.innerText = element.teamName;
        option.dataset.teamLogo = element.teamLogo;

        if(i == 0){
            option.selected = true;
            let teamLogo1 = document.getElementById('teamLogo1');
            let logo = option.dataset.teamLogo;
            teamLogo1.src = `./images/${logo}`;
        }

        team1.appendChild(option);
        team2.appendChild(option.cloneNode(true));
    });
    
    team1.addEventListener('change', (e) => {
        let teamLogo1 = document.getElementById('teamLogo1');
        let objectTarget = [...e.target.options];
        let logo = objectTarget[e.target.options.selectedIndex].dataset.teamLogo;
        teamLogo1.src = `./images/${logo}`;
    })
         
    team2.addEventListener('change', (e) => {
        let teamLogo2 = document.getElementById('teamLogo2');
        let objectTarget = [...e.target.options];
        let logo = objectTarget[e.target.options.selectedIndex].dataset.teamLogo;
        teamLogo2.src = `./images/${logo}`;
    })

    let createMetch = () => {
        let time = new Date();
        let year = time.getFullYear();
        let month = time.getMonth() + 1;
        let day = time.getDate();
        let hour = time.getHours();
        let minutes = time.getMinutes();
        let seconds = time.getSeconds();
        // let date = `${year}-${month}-${day}T${hour}:${minutes}:${seconds}`;
        let date = `${year}-${month}-${day}T${hour}:${minutes}`;

        Swal.fire({
            title: 'Wybierz datę rozpoczęcia meczu i zakończenia meczu',
            // html: `<input type="datetime-local" id="startMatch" name="startMatch" value="${date}" min="${date}"> <br> <input type="datetime-local" id="endMatch" name="endMatch" value="${date}" min="${date}">`, // only hour and minutes
            // only hour and minutes
            html: `<input type="datetime-local" id="startMatch" name="startMatch" value="${date}" min="${date}"> <br> <input type="datetime-local" id="endMatch" name="endMatch" value="${date}" min="${date}">`,
            confirmButtonText: 'Stwórz mecz',
            showCancelButton: true,
            cancelButtonText: 'Anuluj',
            preConfirm: () => {
                let startMatch = document.getElementById('startMatch').value;
                let endMatch = document.getElementById('endMatch').value;
                let team1 = document.getElementById('team1').value;
                let team2 = document.getElementById('team2').value;

                if(startMatch == '' || endMatch == '' || team1 == '' || team2 == ''){
                    Swal.showValidationMessage('Wypełnij wszystkie pola');
                }else{
                    return {startMatch: startMatch, endMatch: endMatch, team1: team1, team2: team2};
                }
            }
        }).then((result) => {
            if(result.isConfirmed){
                let startMatch = result.value.startMatch;
                let endMatch = result.value.endMatch;
                let team1 = result.value.team1;
                let team2 = result.value.team2;

                $.ajax({
                    url: './api/createMatch.php',
                    type: 'POST',
                    data: {startMatch: startMatch, endMatch: endMatch, team1: team1, team2: team2},
                    success: (data) => {
                        if(data == 'success'){
                            Swal.fire({
                                title: 'Mecz został stworzony',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then(() => {
                                location.reload();
                            })
                        }else{
                            console.log(data);
                            Swal.fire({
                                title: 'Wystąpił błąd',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                        }
                    }
                })
            }
        })
    }

</script>