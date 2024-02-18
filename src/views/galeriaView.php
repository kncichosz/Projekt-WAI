<!DOCTYPE HTML>
<html lang="pl">

<head>
    <?php require_once "viewTemplates/headTemplate.php" ?>
</head>

<body>
    <header><?php include "viewTemplates/headerTemplate.php" ?></header>
    <nav><?php include "viewTemplates/navTemplate.php" ?></nav>

    <main>
        <h3>GALERIA</h3>

        <form action="zapiszZdj" method="post">

            <input type="submit" value="Zapamiętaj wybrane">

            <div id="gleria">
            
            <?php

            if(isset($_SESSION['imgTab']))
            {
                unset($_SESSION['imgTab']);            
            }

            if(isset($_SESSION['powrot'])){
                unset($_SESSION['powrot']);
            }

            if(isset($_SESSION['zdjZnakWodny'])){
                unset($_SESSION['zdjZnakWodny']);
            }

            $imgTab = [];
            $i = 0;
            $_SESSION['powrot'] = 'galeria';

            foreach($model['zdjecia'] as $zdj){

                $len = strlen($zdj)-14;
                $id = substr($zdj, 10, $len);
                $img = substr($zdj, 10, $len+4);
                array_push($imgTab, $img);
                $dane = selectZdjDB($id);
                $autor = $dane['autor'];
                $nazwa = $dane['nazwa'];
                $dostep = $dane['dostep'];
                $czy_zapisany = false;

                if($dostep == 'publiczny'){
                
                    if(isset($_SESSION['zapisaneZdj'])){
                        
                        if(in_array($img, $_SESSION['zapisaneZdj'])){
                            $czy_zapisany = true;
                        }
                        else{
                            $czy_zapisany = false;
                        }
                    }
    
                    if( $czy_zapisany == true){
                    
                        echo "<a href='zdjecieZnakWodny?zdj=$i'><div class='zdjGal'><img src='$zdj'><br/><span>Nazwa: $nazwa</span><br/><span>Autor: $autor</span><br/>Publiczne<br/><input type='checkbox' name='zapisaneZdj[]' value='$img' checked disabled></div></a>";
                    }
                    
                    if( $czy_zapisany == false)
                    {
                    
                        echo "<a href='zdjecieZnakWodny?zdj=$i'><div class='zdjGal'><img src='$zdj'><br/><span>Nazwa: $nazwa</span><br/><span>Autor: $autor</span><br/>Publiczne<br/><input type='checkbox' name='zapisaneZdj[]' value='$img'></div></a>";   
    
                    }
                
                }
                else if(isset($_SESSION['aktywnyUser']) && $dostep == 'prywatny'){
                    $aktywnyUser = $_SESSION['aktywnyUser']['autor'];

                    if($aktywnyUser == $autor){
                    
                        if(isset($_SESSION['zapisaneZdj'])){
                        
                            if(in_array($img, $_SESSION['zapisaneZdj'])){
                                $czy_zapisany = true;
                            }
                            else{
                                $czy_zapisany = false;
                            }
                        }
        
                        if( $czy_zapisany == true){
                        
                            echo "<a href='zdjecieZnakWodny?zdj=$i'><div class='zdjGal'><img src='$zdj'><br/><span>Nazwa: $nazwa</span><br/><span>Autor: $autor</span><br/>Prywatne<br/><input type='checkbox' name='zapisaneZdj[]' value='$img' checked disabled></div></a>";
                        }
                        
                        if( $czy_zapisany == false)
                        {
                        
                            echo "<a href='zdjecieZnakWodny?zdj=$i'><div class='zdjGal'><img src='$zdj'><br/><span>Nazwa: $nazwa</span><br/><span>Autor: $autor</span><br/>Prywatne<br/><input type='checkbox' name='zapisaneZdj[]' value='$img'></div></a>";   
        
                        }
                    
                    }
                }
                
                $i++;
            }

            $_SESSION['imgTab'] = $imgTab;

            ?>

            </div>

        </form>

        <div id="przyciski">

        <?php


        if($_SESSION['strona']>1){
            echo "<a href='poprzedniaStrona'><div class='przycisk'>Poprzednia strona</div></a>";
        }

        if($_SESSION['strona']<$_SESSION['ile_stron']){
            echo "<a href='nastepnaStrona'><div class='przycisk'>Następna strona</div></a>";
        }

        ?>

        </div>

    </main>

</body>

</html>