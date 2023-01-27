<div id='component'>
    <div id="titleComponent">Zarządzanie Kontami</div>
    
    <div id="buttonSticky" onclick='createAccount()'>
        <i class="fas fa-plus"></i> Dodaj
    </div>

    <div id="contenerContent">
        <div id="tableMenageUsers">
            <div class="column">
                <div class="row">Id</div>
                <div class="row">Nazwa Użytkownika</div>
                <div class="row">Data utworzenia</div>
                <div class="row">Ostatnia Zmiana</div>
                <div class="row">Akcje</div>
            </div>
            <?php
                $users = $con->query('SELECT * FROM users');
                foreach($users as $row) {
                    echo '<div class="column">';
                    echo '<div class="row">'.$row['id'].'</div>';
                    echo '<div class="row">'.$row['login'].'</div>';
                    echo '<div class="row">'.$row['createdAt'].'</div>';
                    echo '<div class="row">'.$row['updatedAt'].'</div>';
                    echo '<div class="row"> <span onclick="removeAccount('.$row['id'].')"> <i class="fa-solid fa-trash"></i></span> <span onclick="editAccount('.$row['id'].')"><i class="fa-solid fa-user-pen"></i></span> </div>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
</div>

<script>
    let createAccount = () => {
        Swal.fire({
            title: 'Dodaj konto',
            html: '<input id="swal-input1" class="swal2-input" placeholder="Login">' +
                '<input id="swal-input2" class="swal2-input" placeholder="Hasło">' +
                '<input id="swal-input3" class="swal2-input" placeholder="Powtórz hasło">',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Dodaj',
            cancelButtonText: 'Anuluj',
            preConfirm: () => {
                return [
                    document.getElementById('swal-input1').value,
                    document.getElementById('swal-input2').value,
                    document.getElementById('swal-input3').value
                ]
            }
        }).then((result) => {
            if(result.isConfirmed) {
                if(result.value[0] == '') {
                    Swal.fire(
                        'Błąd!',
                        'Login nie może być pusty.',
                        'error'
                    )
                } else if(result.value[1] == '' || result.value[2] == '') {
                    Swal.fire(
                        'Błąd!',
                        'Hasło nie może być puste.',
                        'error'
                    )
                } else if(result.value[1].length < 6) {
                    Swal.fire(
                        'Błąd!',
                        'Hasło musi mieć conajmniej 6 znaków.',
                        'error'
                    )
                } else if(result.value[1] != result.value[2]) {
                    Swal.fire(
                        'Błąd!',
                        'Hasła nie są takie same.',
                        'error'
                    )
                } else {
                    $.post('createAccount', {
                        login: result.value[0],
                        password: result.value[1]
                    }, (data) => {
                        if(data == 'success') {
                            Swal.fire(
                                'Dodano konto!',
                                'Konto zostało dodane.',
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
            }
        })
    }


    let removeAccount = (id) => {
        Swal.fire({
            title: 'Na pewno chcesz usunąć konto?',
            text: "Nie będziesz mógł cofnąć tej akcji!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tak, usuń!',
            cancelButtonText: 'Anuluj'
        }).then((result) => {
            if(result.isConfirmed) {
                $.post('removeAccount', {
                    id: id
                }, (data) => {
                    if(data == 'success') {
                        Swal.fire(
                            'Usunięto konto!',
                            'Konto zostało usunięte.',
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

    let editAccount = (id) => {
        Swal.fire({
            title: 'Edytuj konto',
            html: '<input id="swal-input1" class="swal2-input" placeholder="Login">' +
                '<input id="swal-input2" class="swal2-input" placeholder="Hasło">',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Dodaj',
            cancelButtonText: 'Anuluj',
            preConfirm: () => {
                return [
                    document.getElementById('swal-input1').value,
                    document.getElementById('swal-input2').value
                ]
            }
        }).then((result) => {
            if(result.isConfirmed) {
                $.post('editAccount', {
                    id: id,
                    login: result.value[0] == '' ? null : result.value[0],
                    password: result.value[1] == '' ? null : result.value[1]
                }, (data) => {
                    if(data == 'success') {
                        Swal.fire(
                            'Edytowano konto!',
                            'Konto zostało edytowane.',
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