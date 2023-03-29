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
                $users = $con->query('SELECT * FROM teams');
                foreach($users as $row) {
                    echo '<div class="column">';
                    echo '<div class="row">'.$row['id'].'</div>';
                    echo '<div class="row">'.$row['teamName'].'</div>';
                    echo '<div class="row cursor" onclick="openImage(`'.$row['teamLogo'].'`, `'.$row['teamName'].'`)">'.$row['teamLogo'].'</div>';
                    echo '<div class="row">'.$row['updatedAt'].'</div>';
                    echo '<div class="row"> <span onclick="removeAccount('.$row['id'].')"> <i class="fa-solid fa-trash"></i></span> <span onclick="editAccount('.$row['id'].')"><i class="fa-solid fa-user-pen"></i></span> </div>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
</div>

<script>

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
</style>