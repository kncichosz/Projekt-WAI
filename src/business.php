<?php

function getDB()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);
    return $mongo->wai;
}


function insertDB($nazwa, $dane)
{
    $db = getDB();
    $wynik = $db->$nazwa->insertOne($dane);
    $id = $wynik->getInsertedId();
    return $id;

}

function selectZdjDB($id)
{
    $db = getDB();
    $sth = $db->zdjecia->find();
    foreach($sth as $th)
    {
        if($th['_id'] == $id)
        {
            return $th;
        }
    }
}

function czyIstniejeUserDB($dane)
{
    $db = getDB();
    $flaga = false;
    $sth = $db->user->find();
    foreach ($sth as $th) {
        if($th['autor'] == $dane)
        {
            $flaga = true;
            break;
        }
    }
    return $flaga;

}

function getUserIDBd($dane)
{
    $db = getDB();
    $sth = $db->user->findOne(['autor' => $dane]);
    return $sth;
}