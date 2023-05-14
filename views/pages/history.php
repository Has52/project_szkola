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
                $users = $con->query('SELECT games.id, teams.teamName AS home_team, games.firstTeamId AS home_team_id, COUNT(CASE WHEN goals.teamId = games.firstTeamId AND goals.gameId = games.id THEN goals.id ELSE NULL END) AS home_team_points, t2.teamName AS away_team, games.secondTeamId AS away_team_id, COUNT(CASE WHEN goals.teamId = games.secondTeamId AND goals.gameId = games.id THEN goals.id ELSE NULL END) AS away_team_points, games.start AS start_time, games.end AS end_time FROM games JOIN teams ON games.firstTeamId = teams.id JOIN teams t2 ON games.secondTeamId = t2.id JOIN goals ON goals.gameId = games.id AND (goals.teamId = games.firstTeamId OR goals.teamId = games.secondTeamId) GROUP BY games.id;');
                foreach($users as $row) {
                    echo '<div class="column">';
                    echo '<div class="row">'.$row['id'].'</div>';
                    echo '<div class="row">'.$row['home_team'].'</div>';
                    echo '<div class="row">'.$row['home_team_points'].'</div>';
                    echo '<div class="row">'.$row['away_team'].'</div>';
                    echo '<div class="row">'.$row['away_team_points'].'</div>';
                    echo '<div class="row">'.$row['start_time'].'</div>';
                    echo '<div class="row">'.$row['end_time'].'</div>';
                    echo '<div class="row"> <span><i class="fa-solid fa-gear"></i></span> </div>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
</div>