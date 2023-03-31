<div id='component'>
    <div id="titleComponent">Zarządzanie druzynami</div>

    <div id="contenerContent">
        <div id="tableMenageUsers">
            <div class="column">
                <div class="row">ID</div>
                <div class="row">Nazwa druzyny</div>
                <div class="row">Logo druzyny</div>
                <div class="row">Ostatnia Zmiana</div>
                <div class="row">Akcje</div>
            </div>
            <?php
                $teams = $con->query('SELECT * FROM teams');
                foreach($teams as $row) {
                    $players = $con->query('SELECT id, playerName, playerTeamId FROM players WHERE playerTeamId = '.$row['id'].'');
                    $players = str_replace('"', "'", json_encode($players->fetch_all(MYSQLI_ASSOC)));

                    echo '<div class="column">';
                    echo '<div class="row">'.$row['id'].'</div>';
                    echo '<div class="row">'.$row['teamName'].'</div>';
                    echo '<div class="row cursor" onclick="openImage(`'.$row['teamLogo'].'`, `'.$row['teamName'].'`)">'.$row['teamLogo'].'</div>';
                    echo '<div class="row">'.$row['updatedAt'].'</div>';
                    // echo '<div class="row"> <span onclick="removeAccount('.$row['id'].')"> <i class="fa-solid fa-trash"></i></span> <span onclick="editTeam('.$row['id'].')"><i class="fa-solid fa-user-pen"></i></span> </div>';
                    echo '<div class="row"> <span onclick="removeAccount('.$row['id'].')"> <i class="fa-solid fa-trash"></i></span> <span onclick="editTeam(`'.$row['id'].'`, `'.$row['teamLogo'].'`, `'.$row['teamName'].'`, '.$players.')"><i class="fa-solid fa-user-pen"></i></span> </div>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
</div>

<script>

    let editTeam = async (id, logo, teamName, players) => {
        let htmlPlayers = '';        
        for(let i = 0; i < players.length; i++) {
            htmlPlayers += `
                <div class="rowPlayersTeam">
                    <div class="columnPlayersTeam">
                        <div class="rowPlayersTeam">ID</div>
                        <div class="rowPlayersTeam">Nazwa Zawodnika</div>
                        <div class="rowPlayersTeam">Id Drużyny</div>
                    </div>
                    <div class="columnPlayersTeam">
                        <div class="rowPlayersTeam">${players[i].id}</div>
                        <input type="text" value="${players[i].playerName}">
                        <input type="text" value="${players[i].playerTeamId}">
                    </div>
                </div>
            `;
        }

        Swal.fire({
            title: 'Edytuj Drużynę',
            html: `
                <div class="rowPlayersTeam">
                    <div class="columnPlayersTeam">
                        <div class="rowPlayersTeam">Logo</div>
                        <input type="text" value="${logo}">
                    </div>
                    <div class="columnPlayersTeam">
                        <div class="rowPlayersTeam">Nazwa Drużyny</div>
                        <input type="text" value="${teamName}">
                    </div>
                </div>
                <div class="rowPlayersTeam">
                    <div class="columnPlayersTeam">
                        <div class="rowPlayersTeam">Zawodnicy</div>
                        ${htmlPlayers}
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Zapisz',
            cancelButtonText: 'Anuluj',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if(result.isConfirmed) {
                let logo = document.querySelectorAll('.swal2-html-container input')[0].value;
                let teamName = document.querySelectorAll('.swal2-html-container input')[1].value;
                let players = [];
                let inputs = document.querySelectorAll('.swal2-html-container input');
                for(let i = 2; i < inputs.length; i++) {
                    players.push(inputs[i].value);
                }

                $.post('./api/editTeam.php', {
                    id: id,
                    logo: logo,
                    teamName: teamName,
                    players: players
                }, (data) => {
                    if(data == 'success') {
                        Swal.fire(
                            'Zapisano zmiany!',
                            'Zmiany zostały zapisane.',
                            'success'
                        ).then(() => {
                            location.reload();
                        })
                    } else {
                        Swal.fire(
                            'Błąd!',
                            'Coś poszło nie tak, spróbuj ponownie.',
                            'error'
                        )
                    }
                })
            }
        })

    }

    let openImage = (logo, teamName) => {
        Swal.fire({
            title: 'Logo',
            text: teamName || 'team nazwa',
            imageUrl: `./images/${logo}`,
            imageWidth: 200,
        })
    }


    let removeAccount = (id) => {
        Swal.fire({
            title: 'Na pewno chcesz usunąć drużynę?',
            text: "Nie będziesz mógł cofnąć tej akcji!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tak, usuń!',
            cancelButtonText: 'Anuluj'
        }).then((result) => {
            if(result.isConfirmed) {
                $.post('./api/removeTeam.php', {
                    id: id
                }, (data) => {
                    if(data == 'success') {
                        Swal.fire(
                            'Usunięto Drużynę!',
                            'Druzyna została usunięta.',
                            'success'
                        ).then(() => {
                            location.reload();
                        })
                    } else {
                        Swal.fire(
                            'Błąd!',
                            'Coś poszło nie tak, spróbuj ponownie.',
                            'error'
                        )
                    }
                })
            }
        })
    }


</script>

<style>
    .cursor{
        cursor: pointer;
    }

    .rowPlayersTeam {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin: 5px 0;
    }

    .columnPlayersTeam {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }

    .rowPlayersTeam div {
        margin: 5px 0;
    }

    .rowPlayersTeam input {
        width: 100%;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    

    
</style>