<!DOCTYPE HTML>
<html lang="pl">

<head>
    <?php require_once "viewTemplates/headTemplate.php" ?>
</head>

<body>
    <header><?php include "viewTemplates/headerTemplate.php" ?></header>
    <nav><?php include "viewTemplates/navTemplate.php" ?></nav>
    <main>

        <h3>ZAPISANE ZDJĘCIA</h3>

        <form action="usunZaznaczone" method="post">

            <input type="submit" value="Usuń zaznaczone z zapamiętanych">

            <div id="gleria">

            <?php

            if(isset($_SESSION['powrot'])){
                unset($_SESSION['powrot']);
            }

            if(isset($_SESSION['zdjZnakWodny'])){
                unset($_SESSION['zdjZnakWodny']);
            }

            if(isset($_SESSION['zapisaneZdj'])){

                if(isset($_SESSION['imgTab']))
                {
                    unset($_SESSION['imgTab']);            
                }
            
                $imgTab= [];
                $i = 0;
                $_SESSION['powrot'] = 'zapisane';
                $ile_stron = ceil(count($_SESSION['zapisaneZdj'])/9);

                for($j=($_SESSION['stronaZapisane']-1)*9; $j <= (($_SESSION['stronaZapisane']-1)*9)+8; $j++){

                    if(!isset($_SESSION['zapisaneZdj'][$j])){
                        break;
                    }else{
                    
                        $img = $_SESSION['zapisaneZdj'][$j];
                    }

                    $len = strlen($img)-4;
                    $id = substr($img, 0, $len);
                    array_push($imgTab, $img);
                    $dane = selectZdjDB($id);
                    $autor = $dane['autor'];
                    $nazwa = $dane['nazwa'];
                
                    echo "<a href='zdjecieZnakWodny?zdj=$i'><div class='zdjGal'><img src='imagesMin/$img'><br/><span>Nazwa: $nazwa</span><br/><span>Autor: $autor</span><br/><input type='checkbox' name='usunZdj[]' value='$img'></div></a>"; 
                
                    $i++;
                
                }

                $_SESSION['imgTab'] = $imgTab;
            
            }

            ?>

            </div>
        </form>

        <div id="przyciski">

        <?php

        if(isset($_SESSION['zapisaneZdj'])){

            if($_SESSION['stronaZapisane']>1){
                echo "<a href='poprzedniaStronaZapis'><div class='przycisk'>Poprzednia strona</div></a>";
            }

            if($_SESSION['stronaZapisane']<$ile_stron){
                echo "<a href='nastepnaStronaZapis'><div class='przycisk'>Następna strona</div></a>";
            }

        }

        ?>

        </div>

    </main>
</body>

</html>