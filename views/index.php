<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mecze</title>
    <?php
        echo('<link rel="stylesheet" href="'.$path.'/assets/main.css">');
    ?>
    <script src="https://use.fontawesome.com/releases/v6.2.1/js/all.js" data-auto-replace-svg="nest"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div id="main">
        <div class="custom-shape-divider-top-1674637289">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
            </svg>
        </div>
        <?php
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = mysqli_real_escape_string($con, $_POST['username']);
                $password = mysqli_real_escape_string($con, $_POST['password']);
                $result = mysqli_query($con, "SELECT * FROM users WHERE login='$username' AND password=SHA1('$password')");
                if (mysqli_num_rows($result) == 1) {
                    $_SESSION['username'] = $username;
                    header('Location: '.$path);
                } else {
                    echo '<div id="wrongPassword"><p><i class="fa-solid fa-circle-xmark"></i>Nieprawidłowa nazwa użytkownika lub hasło</p></div>';
                }
            }
            
        ?>


        <!-- Menu Page -->
        <?php if(isset($_SESSION['username'])): ?>
        <div id="mainContent">
            <div id="leftMainContent">
                <div id="upperLeftMainConent">
                    <a href="index.php" class="buttonLeftMainConent"><i class="fas fa-home"></i> Strona główna</a>
                    <a href="index.php?page=addMatch" class="buttonLeftMainConent"><i class="fas fa-plus"></i> Dodaj mecz</a>
                    <a href="index.php?page=history" class="buttonLeftMainConent"><i class="fas fa-history"></i> Historia meczy</a>
                    <a href="index.php?page=addTeam" class="buttonLeftMainConent"><i class="fas fa-plus"></i> Dodaj drużynę</a>
                    <a href="index.php?page=editTeam" class="buttonLeftMainConent"><i class="fas fa-edit"></i> Edytuj drużynę</a>
                    <a href="index.php?page=menageUsers" class="buttonLeftMainConent"><i class="fas fa-users"></i> Zarządzanie Kontami</a>
                </div>
                <div id="downLeftMainContent">
                    <a href="index.php?page=showMatch" class="buttonLeftMainConent"><i class="fas fa-trophy"></i>Wyświetl Mecz</a>
                    <a href="index.php?page=logout" class="buttonLeftMainConent"><i class="fas fa-sign-out-alt"></i> Wyloguj</a>
                </div>
            </div>
            <div id="rightMainContent">
                <?php 

                    if(isset($_GET['page'])) { 

                        if($_GET['page'] == 'logout') {
                            header('Location: logout');
                        }

                        include('pages/'.$_GET['page'].'.php');
                    } else {
                        include('pages/main.php');
                    }
                ?>
            </div>
        </div>
    
        <!-- Login Page -->
        <?php else: ?>
        <div id="loginCointainer">
            <div id="loginTitle">Logowanie</div>
            <form action="" method="post" id='loginForm'>
                <div id="loginInputs">
                    <div class="loginInput">
                        <div class="loginTitle">Nazwa użytkownika</div>
                        <div class="inputs">
                            <div class="iconInput">
                                <i class="fas fa-user"></i>
                            </div>
                            <input type="text" class="input" name="username">
                        </div>
                    </div>
                    <div class="loginInput">
                        <div class="loginTitle">Hasło</div>
                        <div class="inputs">
                            <div class="iconInput">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" class="input" name="password">
                        </div>
                    </div>
                </div>
                <div id="loginButton">
                    <input type="submit" id="button" class="input" value="Zaloguj się">
                </div>
            </form>
        </div>
        <div id="footballPlayer">
            <img src="./assets/Football_player.png">
        </div>
        <?php endif ?>
    </div>
    <script>
        const footballPlayer = document.getElementById('footballPlayer');
        if(footballPlayer != null) {
            const img = footballPlayer.children[0];
            img.src = documentOrgin + '/assets/Football_player.png '
        }
    </script>
</body>
</html>