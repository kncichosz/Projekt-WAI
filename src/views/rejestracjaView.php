<!DOCTYPE HTML>
<html lang="pl">

<head>
    <?php require_once "viewTemplates/headTemplate.php" ?>
</head>

<body>
    <header><?php include "viewTemplates/headerTemplate.php" ?></header>
    <nav><?php include "viewTemplates/navTemplate.php" ?></nav>
    <main>

        <h3>Rejestracja</h3>

        <form action="utworzKonto" method="post">

            <label for="email">Wprowadź email: </label><br>
            <input type="email" id="email" name="email"><br>

            <label for="login">Wprowadź login: </label><br>
            <input type="text" id="login" name="login"><br>

            <label for="haslo">Wprowadź hasło: </label><br>
            <input type="password" id="haslo" name="haslo"><br>

            <label for="haslo2">Powtórz hasło: </label><br>
            <input type="password" id="haslo2" name="haslo2"><br><br>

            <input type="submit">

        </form>

        <?php

            if(isset($_SESSION['rejesMailErr']))
            {
                echo $_SESSION['rejesMailErr']."<br/>";
                unset($_SESSION['rejesMailErr']);
            }

            if(isset($_SESSION['rejesLoginErr']))
            {
                echo $_SESSION['rejesLoginErr']."<br/>";
                unset($_SESSION['rejesLoginErr']);
            }

            if(isset($_SESSION['rejesPassErr']))
            {
                echo $_SESSION['rejesPassErr']."<br/>";
                unset($_SESSION['rejesPassErr']);
            }

            if(isset($_SESSION['rejesPass2Err']))
            {
                echo $_SESSION['rejesPass2Err']."<br/>";
                unset($_SESSION['rejesPass2Err']);
            }

            if(isset($_SESSION['rejesHaslaErr']))
            {
                echo $_SESSION['rejesHaslaErr']."<br/>";
                unset($_SESSION['rejesHaslaErr']);
            }

            if(isset($_SESSION['rejesTrue']))
            {
                echo $_SESSION['rejesTrue']."<br/>";
                unset($_SESSION['rejesTrue']);
            }

        ?>

    </main>
</body>

</html>