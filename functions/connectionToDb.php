<?php
function connectionToDb(string $host, string $dbName, string $dbUser, string $userPassword): object
{
    try {
        $connexion = new PDO("mysql:host=$host;dbname=$dbName",$dbUser,$userPassword);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connexion;
    }catch(PDOException $error){
        echo('ERREUR : Connexion Echouée : '.$error->getMessage());
    }
    return $error;
}

$connection = connectionToDb("localhost", "bd_wordpress_project", "root", "");