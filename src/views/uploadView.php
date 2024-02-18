<!DOCTYPE HTML>
<html lang="pl">

<head>
    <?php require_once "viewTemplates/headTemplate.php" ?>
</head>

<body>
    <header><?php include "viewTemplates/headerTemplate.php" ?></header>
    <nav><?php include "viewTemplates/navTemplate.php" ?></nav>
    
    <main>

        <form action="uploadZdjecia" method="post" enctype="multipart/form-data">
        
                <h3>Informacje o zdjęciu:</h3>
                <label for="labZdjAutor">Autor zdjęcia:</label></br>
                
                <?php 
                    
                    if(isset($_SESSION['aktywnyUser'])){
                        $user = $_SESSION['aktywnyUser']['autor'];
                        echo "<input type='text' id='labZdjAutor' value = '$user' disabled >";
                        echo "<input type='hidden' name='zdjAutor' value = '$user'>";
                    }else{
                        echo "<input type='text' name='zdjAutor' id='labZdjAutor'>";
                    }
                
                ?>
                
                </br></br>
                <label for="labZdjTytul">Nazwa zdjęcia:</label></br>
                <input type="text" name="zdjTytul" id="labZdjTytul"></br></br>
                <label for="labZnakWodny">Znak wodny:</label></br>
                <input type="text" name="znakWodny" id="labZnakWodny"></br></br>
                <?php
                
                    if(isset($_SESSION['aktywnyUser'])){
                        
                        echo 'Dostęp do zdjecia:<br/>';
                        echo "<input type='radio' name='dostep' value='publiczny' id='publiczny' checked='checked'><label for='publiczny'>Publiczny</label><br/>";
                        echo "<input type='radio' name='dostep' value='prywatny' id='prywatny'><label for='prywatny'>Prywatny</label><br/><br/>";

                    }
                
                ?>
                
                <input type="file" name="zdjecie" accept=".png,.jpg,.pdf"><br><br>
                <input type="submit"><br>

                <?php

                    if(isset($_SESSION['upladErr']))
                    {
                        echo $_SESSION['upladErr']."<br/>";
                        unset($_SESSION['upladErr']);
                    }

                ?>

        </form>

    </main>

</body>

</html>