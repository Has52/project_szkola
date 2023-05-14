<div id='component'>
    <div id="titleComponent">Historia meczy</div>
    <div id="contenerContent">
        <div id="tableMenageHistoryMatch">
            <div class="column">
                <div class="row">ID</div>
                <div class="row">Team 1</div>
                <div class="row">Pkt 1</div>
                <div class="row">Team 2</div>
                <div class="row">Pkt 2</div>
                <div class="row">Start</div>
                <div class="row">Koniec</div>
                <div class="row">Akcje</div>
            </div>
            <?php
                $data = $con->query('SELECT games.id, teams.teamName AS home_team, games.firstTeamId AS home_team_id, COALESCE(COUNT(CASE WHEN goals.teamId = games.firstTeamId AND goals.gameId = games.id THEN goals.id ELSE NULL END), 0) AS home_team_points, t2.teamName AS away_team, games.secondTeamId AS away_team_id, COALESCE(COUNT(CASE WHEN goals.teamId = games.secondTeamId AND goals.gameId = games.id THEN goals.id ELSE NULL END), 0) AS away_team_points, games.start AS start_time, games.end AS end_time FROM games JOIN teams ON games.firstTeamId = teams.id JOIN teams t2 ON games.secondTeamId = t2.id LEFT JOIN goals ON goals.gameId = games.id AND (goals.teamId = games.firstTeamId OR goals.teamId = games.secondTeamId) GROUP BY games.id;');
                foreach($data as $row) {
                    $players_team_1 = $con->query('SELECT id, playerName, playerTeamId FROM players WHERE playerTeamId = '.$row['home_team_id'].'');
                    $players_team_2 = $con->query('SELECT id, playerName, playerTeamId FROM players WHERE playerTeamId = '.$row['away_team_id'].'');

                    $players_team_1 = str_replace('"', "'", json_encode($players_team_1->fetch_all(MYSQLI_ASSOC)));
                    $players_team_2 = str_replace('"', "'", json_encode($players_team_2->fetch_all(MYSQLI_ASSOC)));

                    echo '<div class="column">';
                    echo '<div class="row">'.$row['id'].'</div>';
                    echo '<div class="row">'.$row['home_team'].'</div>';
                    echo '<div class="row">'.$row['home_team_points'].'</div>';
                    echo '<div class="row">'.$row['away_team'].'</div>';
                    echo '<div class="row">'.$row['away_team_points'].'</div>';
                    echo '<div class="row">'.$row['start_time'].'</div>';
                    echo '<div class="row">'.$row['end_time'].'</div>';
                    echo '<div class="row"> <span><i class="fa-solid fa-basketball" onclick="addPointsMatch('.$players_team_1.', '.$players_team_2.', '.$row['id'].', \''.$row['home_team'].'\', \''.$row['away_team'].'\', '.$row['home_team_id'].', '.$row['away_team_id'].')"></i></span> </div>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
</div>

<script>
    let addPointsMatch = (playersTeam1, playersTeam2, match_id, home_team_name, away_team_name, home_team_id, away_team_id) => {
        let htmlPlayersTeam1 = '';
        let htmlPlayersTeam2 = '';

        for(let i = 0; i < playersTeam1.length; i++) {
            htmlPlayersTeam1 += `<option value='${playersTeam1[i].id}'>${playersTeam1[i].playerName}</option>`;
        }

        for(let i = 0; i < playersTeam2.length; i++) {
            htmlPlayersTeam2 += `<option value='${playersTeam2[i].id}'>${playersTeam2[i].playerName}</option>`;
        }

        Swal.fire({
            title: 'Dodaj punkty',
            html: `<h1>Wybierz drużynę</h1><select id='selectTeams'><option value='${home_team_id}'>${home_team_name}</option><option value='${away_team_id}'>${away_team_name}</option></select>`,
            showCancelButton: true,
            confirmButtonText: 'Zapisz',
            cancelButtonText: 'Anuluj',
            showLoaderOnConfirm: true,
        }).then((result) => {
            if(result.isConfirmed) {
                let team_id = document.getElementById('selectTeams').value;

                Swal.fire({
                    title: 'Edytuj mecz',
                    html: `<h1>Wybierz zawodnika</h1><select id='selectPlayers'>${team_id == home_team_id ? htmlPlayersTeam1 : htmlPlayersTeam2}</select>`,
                    showCancelButton: true,
                    confirmButtonText: 'Zapisz',
                    cancelButtonText: 'Anuluj',
                    showLoaderOnConfirm: true,
                }).then((result) => {
                    if(result.isConfirmed) {
                        let player_id = document.getElementById('selectPlayers').value;

                        Swal.fire({
                            title: 'Edytuj mecz',
                            html: `<h1>Podaj ilość punktów</h1><input type='number' id='points'>`,
                            showCancelButton: true,
                            confirmButtonText: 'Zapisz',
                            cancelButtonText: 'Anuluj',
                            showLoaderOnConfirm: true,
                        }).then((result) => {
                            if(result.isConfirmed) {
                                let points = document.getElementById('points').value;

                                $.post('./api/addPoints.php', {
                                    player_id: player_id,
                                    match_id: match_id,
                                    points: points,
                                    team_id: team_id
                                }, (data) => {
                                    if(data == 'success') {
                                        Swal.fire({
                                            title: 'Sukces',
                                            text: 'Punkty zostały dodane',
                                            icon: 'success',
                                            confirmButtonText: 'Ok'
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Błąd',
                                            text: 'Wystąpił błąd podczas dodawania punktów',
                                            icon: 'error',
                                            confirmButtonText: 'Ok'
                                        });
                                    }
                                })

                            }
                        });
                    }
                });
            }
        })

   }
</script>