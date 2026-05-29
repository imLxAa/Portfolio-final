<?php
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=boal5164_portfolio;charset=utf8','boal5164_admin','EpseQ8749',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(Exception $e)
    {
        die('Erreur: '.$e->getMessage());
    }
?>