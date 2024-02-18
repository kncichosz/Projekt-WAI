<!DOCTYPE HTML>
<html lang="pl">

<head>
    <?php require_once "viewTemplates/headTemplate.php" ?>
</head>

<body>
    <header><?php include "viewTemplates/headerTemplate.php" ?></header>
    <nav><?php include "viewTemplates/navTemplate.php" ?></nav>
    <main>

        <h3>Zaloguj się</h3>

        <form action="logowanieUser" method="post">

            <label for="login">Podaj login: </label><br>
            <input type="text" id="login" name="login"><br>

            <label for="haslo">Podaj hasło: </label><br>
            <input type="password" id="haslo" name="haslo"><br><br>

            <input type="submit">

        </form>

        <?php

            if(isset($_SESSION['logoLoginErr']))
            {
                echo $_SESSION['logoLoginErr']."<br/>";
                unset($_SESSION['logoLoginErr']);
            }

            if(isset($_SESSION['logoPassErr']))
            {
                echo $_SESSION['logoPassErr']."<br/>";
                unset($_SESSION['logoPassErr']);
            }

        ?>

    </main>
</body>

</html>