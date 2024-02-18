<?php
require_once 'business.php';

function glowna(&$model)
{
    $model['activesite'] = 'glowna';
    return 'glownaView';
}

function upload(&$model)
{
    $model['activesite'] = 'upload';
    return 'uploadView';
}

function uploadZdjecia()
{
    $czyErr = true;
    $autor = $_POST['zdjAutor'];
    $tytul = $_POST['zdjTytul'];
    $znakWodny = $_POST['znakWodny'];
    $zdj = $_FILES['zdjecie'];

    if(empty($_POST['zdjAutor']) || !isset($_POST['zdjAutor'])){
        $czyErr = false;
        $_SESSION['upladErr'] = 'Nie podano nazwy autora.';
        return 'redirect:upload';
        exit();
    }
    else if(empty($_POST['zdjTytul']) || !isset($_POST['zdjTytul'])){
        $czyErr = false;
        $_SESSION['upladErr'] = 'Nie podano nazwy zdjecia.';
        return 'redirect:upload';
        exit();
    }

    else if(empty($_POST['znakWodny']) || !isset($_POST['znakWodny'])){
        $czyErr = false;
        $_SESSION['upladErr'] = 'Nie podano znaku wodnego.';
        return 'redirect:upload';
        exit();
    }

    if(isset($_SESSION['aktywnyUser'])){

        $dostep = $_POST['dostep'];

    }else{
        $dostep = 'publiczny';
    }

    if(isset($zdj))
    {     

        if (!file_exists($zdj['tmp_name']))
        {
            $czyErr = false;
            $_SESSION['upladErr'] = 'Nie podano pliku.';
            return 'redirect:upload';
            exit();
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $rozmiarZdj = getimagesize($zdj['tmp_name']);

        if(isset($zdj['tmp_name']))
        {
            $typZ = finfo_file($finfo, $zdj['tmp_name']);

            if($typZ === 'image/jpeg')
            {
                $type = 'jpg';
            }
            else if($typZ === 'image/png')
            {
                $type = 'png';
            }
            else
            {
                $czyErr = false;
                $_SESSION['upladErr'] = 'Nieprawidłowe rozszerzenie pliku.';
            }
            finfo_close($finfo);
        }


        if($zdj['size'] > 1048576)
        {
            $czyErr = false;
            $_SESSION['upladErr'] = 'Zdjecie zajmuje powyżej 1MB.';
        }

    }


    if($czyErr){
        
        $dane = [
            'nazwa' => $tytul,
            'autor' => $autor,
            'typ' => $type,
            'dostep' => $dostep
        ];

        $id = insertDB('zdjecia', $dane);
        $scieszka = 'images/'.$id.".".$type;

        if(is_uploaded_file($zdj['tmp_name'])){

            move_uploaded_file($zdj['tmp_name'], $scieszka);
    
        }

        $scieszkaMin = 'imagesMin/'.$id.".".$type;

        if($type === 'jpg')
        {
            $typModyfikacja = imagecreatefromjpeg($scieszka);
        }
            
        else if($type === 'png')
        {
            $typModyfikacja = imagecreatefrompng($scieszka);
        }
            

        $zdjecieMin = imagescale($typModyfikacja,200,125);
        imagejpeg($zdjecieMin,$scieszkaMin);

        $scieszkaZnakWodny = 'imagesZnakWodny/'.$id.".".$type;
        
        $kolor = imagecolorallocatealpha($typModyfikacja, 0, 0, 0, 50);

        $czcionka = './static/Arial.ttf';

        $rozmiar = ($rozmiarZdj[0]/(strlen($znakWodny)+2))*0.8;

        imagefttext($typModyfikacja, $rozmiar, 0, 10,$rozmiar+20,$kolor, $czcionka, $znakWodny);
        imagejpeg($typModyfikacja, $scieszkaZnakWodny);

    }
    return 'redirect:upload';
}

function galeria(&$model)
{

    $plikiPNG = glob('imagesMin/*.png');
    $plikiJPG = glob('imagesMin/*.jpg');
    $plikiALL = array_merge($plikiPNG, $plikiJPG);

    foreach($plikiALL as $zdj){
    
        $len = strlen($zdj)-14;
        $id = substr($zdj, 10, $len);
        $dane = selectZdjDB($id);
        $dostep = $dane['dostep'];
        $autor = $dane['autor'];

        if($dostep == 'prywatny' && (!isset($_SESSION['aktywnyUser']) || (isset($_SESSION['aktywnyUser']) && $dostep == 'prywatny' && $autor != $_SESSION['aktywnyUser']['autor']))){
            $klucz = array_search($zdj, $plikiALL);
            array_splice($plikiALL, $klucz, 1);
        }
    
    }

    $ilosc = sizeof($plikiALL);
    $_SESSION['ile_stron'] = ceil($ilosc/9);
    $photoAmount = 9;
    $zdjeciaALL = [];

    if(!isset($_SESSION['strona'])){
        $_SESSION['strona'] = 1;
    }

    for($i=0;$i<$photoAmount;$i++)
    {  

        $obecneZdj = (($_SESSION['strona']-1)*$photoAmount)+$i;
        if($obecneZdj>=$ilosc){
            break;
        }
        array_push($zdjeciaALL, $plikiALL[$obecneZdj]);
    }

    
    $model['zdjecia'] = $zdjeciaALL;

    $model['activesite'] = 'galeria';
    return 'galeriaView';
}

function zdjecieZnakWodny(&$model)
{

    $zdj = $_GET['zdj'];
    $imgTab = $_SESSION['imgTab'];

    $_SESSION['zdjZnakWodny'] = $imgTab[$zdj];

    $model['activesite'] = 'zdjecie';
    return 'redirect:zdjecie';
}

function zdjecie(&$model)
{

    $model['activesite'] = 'zdjecie';
    return 'zdjecieView';
}

function poprzedniaStrona()
{
    if($_SESSION['strona'] > 1)
        $_SESSION['strona'] = $_SESSION['strona']-1;
    return 'redirect:galeria';
}

function nastepnaStrona()
{
    $_SESSION['strona'] = $_SESSION['strona']+1;
    return 'redirect:galeria';
}

function poprzedniaStronaZapis()
{
    if($_SESSION['stronaZapisane'] > 1)
        $_SESSION['stronaZapisane'] = $_SESSION['stronaZapisane']-1;
    return 'redirect:zapisane';
}

function nastepnaStronaZapis()
{
    $_SESSION['stronaZapisane'] = $_SESSION['stronaZapisane']+1;
    return 'redirect:zapisane';
}

function login(&$model)
{
    $model['activesite'] = 'login';
    return 'loginView';
}

function rejestracja(&$model)
{
    $model['activesite'] = 'rejestracja';
    return 'rejestracjaView';
}

function konto(&$model)
{
    $model['activesite'] = 'konto';
    return 'kontoView';
}

function wyloguj()
{
    unset($_SESSION['aktywnyUser']);
    return 'redirect:konto';
}

function zapisane(&$model)
{

    if(!isset($_SESSION['stronaZapisane'])){
    
        $_SESSION['stronaZapisane'] = 1;

    }

    $model['activesite'] = 'zapisane';
    return 'zapisaneView';
}

function utworzKonto(){

    $czyErr = true;
    $mail = $_POST['email'];
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    $haslo2 = $_POST['haslo2'];

    if(empty($_POST['email'])){
        $czyErr = false;
        $_SESSION['rejesMailErr'] = 'Nie podano adresu e-maila.';
    }

    if(empty($_POST['login'])){
        $czyErr = false;
        $_SESSION['rejesLoginErr'] = 'Nie podano loginu.';
    }
    else if (czyIstniejeUserDB($login)){
        $czyErr = false;
        $_SESSION['rejesLoginErr'] = 'Podany login już istnieje.';
    }

    if(empty($_POST['haslo'])){
        $czyErr = false;
        $_SESSION['rejesPassErr'] = 'Nie podano hasła.';
    }

    if(empty($_POST['haslo2'])){
        $czyErr = false;
        $_SESSION['rejesPass2Err'] = 'Nie powtórzono hasła.';
    }

    if(!empty($_POST['haslo']) && !empty($_POST['haslo2']) && ($haslo != $haslo2)){
    
        $czyErr = false;
        $_SESSION['rejesHaslaErr'] = 'Podane hasla nie są takie same.';
    }

    if($czyErr){

        $pass = password_hash($haslo, PASSWORD_DEFAULT);
    
        $dane = [
            'autor' => $login,
            'haslo' => $pass,
            'mail' => $mail
        ];

        insertDB('user', $dane);

        $_SESSION['rejesTrue'] = "Poprawnie zarejestrowano użytkownika $login.";
        
    }

    return 'redirect:rejestracja';
}

function logowanieUser(){

    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    $pass = password_hash($haslo, PASSWORD_DEFAULT); 

    if(empty($_POST['login'])){
        $_SESSION['logoLoginErr'] = 'Nie podano loginu.';
    }

    if(empty($_POST['haslo'])){
        $_SESSION['logoPassErr'] = 'Nie podano hasła.';
    }

    if(czyIstniejeUserDB($login) && !empty($login)){

        $user = getUserIDBd($login);
        if(password_verify($haslo, $user['haslo']) && !empty($haslo)){
            $_SESSION['logoTrue'] = 'Poprawne logowanie na konto użytkownika: '.$login;
            $_SESSION['aktywnyUser'] = $user;
            return 'redirect:konto';
            exit();
        }
        else{
            $_SESSION['logoPassErr'] = 'Podano nieprawidlowe hasło.';
        }
    }else{
        $_SESSION['logoLoginErr'] = 'Podany login nie istnieje.';
    }

    return 'redirect:login';
}

function zapiszZdj(){

    if(!isset($_SESSION['zapisaneZdj'])){
        $_SESSION['zapisaneZdj'] = [];
    }

    if(isset($_POST['zapisaneZdj']))
    {
    
        $zapisaneZdj = $_POST['zapisaneZdj'];

        foreach($zapisaneZdj as $zdj){

            if(in_array($zdj, $_SESSION['zapisaneZdj'])){
                continue;
            }else{
                array_push($_SESSION['zapisaneZdj'], $zdj);
            }

        }
    
    }

    return 'redirect:galeria';
}

function usunZaznaczone(){


    if(isset($_POST['usunZdj']))
    {
    
        $usunZdj = $_POST['usunZdj'];

        foreach($usunZdj as $zdj){

            $klucz = array_search($zdj, $_SESSION['zapisaneZdj']);
            array_splice($_SESSION['zapisaneZdj'], $klucz, 1);

        }
    
    }

    return 'redirect:zapisane';
}