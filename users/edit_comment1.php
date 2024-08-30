<?php
session_start();
global $connection;
$title = "Modifier un commentaire";
include ("../commonFiles/header.php");
include_once('../commonFiles/navbar.php');
include("../functions/connectionToDb.php");

if ( isset($_POST['editer'])){
// Vérification si l'email existe déjà dans la base de données
$reqete_mail_existe = $connection->prepare("UPDATE comments SET content = :comment, created_at = NOW() WHERE comments.id = :id_commentaire");
$reqete_mail_existe->bindParam(':comment', $_POST['comment']);
$reqete_mail_existe->bindParam(':id_commentaire', $_POST['id_commentaire']);
$reqete_mail_existe->execute();

// Redirection vers la page d'accueil après l'inscription
header('Location: view_articles.php');
exit();
}