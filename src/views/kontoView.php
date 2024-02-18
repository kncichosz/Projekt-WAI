<!DOCTYPE HTML>
<html lang="pl">

<head>
    <?php require_once "viewTemplates/headTemplate.php" ?>
</head>

<body>
    <header><?php include "viewTemplates/headerTemplate.php" ?></header>
    <nav><?php include "viewTemplates/navTemplate.php" ?></nav>
    <main>

        <?php

        if(!isset($_SESSION['aktywnyUser'])){
        
            echo "<div id='przyciski'><a href='login'><div class='przycisk'>LOGOWANIE</div></a><a href='rejestracja'><div class='przycisk'>REJESTRACJA</div></a></div>";
        }
        else{

            $user = $_SESSION['aktywnyUser'];

            echo "Poprawne logowanie na konto użytkownika: ".$user['autor'];

            echo "<div id='przyciski'><a href='wyloguj'><div class='przycisk'>WYLOGUJ</div></a></div>";
        }

        ?>

    </main>
</body>

</html>