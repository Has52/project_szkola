<div id='component'>
    <div id="mainComponent">
        <div id="mainHomeTitle">
            Witaj, <?php echo $_SESSION['username'] ?>
            <div id="subTitleMainHome">Wybierz opcje, aby kontynuować</div>
        </div>
        <div id="buttonsMain">
                <a href="index.php?page=addMatch" class="buttonMain">Dodaj mecz</a>
                <a href="index.php?page=history" class="buttonMain">Historia meczy</a>
                <a href="index.php?page=addTeam" class="buttonMain">Dodaj drużynę</a>
                <a href="index.php?page=editTeam" class="buttonMain">Edytuj drużynę</a>
                <a href="index.php?page=menageUsers" class="buttonMain">Zarządzanie Kontami</a>
        </div>
    </div>
</div>

<style scoped>
    #mainComponent{
        margin: auto;
    }
</style>