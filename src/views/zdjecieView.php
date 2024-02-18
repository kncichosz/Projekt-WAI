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

        

        echo "<img src='imagesZnakWodny/".$_SESSION['zdjZnakWodny']."'>";

        ?>

        <br>
        <div id="przyciski">

            <?php

                if($_SESSION['powrot'] == 'zapisane'){
                
                    echo "<a href='zapisane'><div class='przycisk'>POWROT</div></a>";
                
                }
                else if($_SESSION['powrot'] == 'galeria'){
                
                    echo "<a href='galeria'><div class='przycisk'>POWROT</div></a>";
                }

            ?>
            
        </div>

    </main>

</body>

</html>