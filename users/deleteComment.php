<?php
global $connection;
session_start();
$title = "S'inscrire";
include ("../commonFiles/header.php");

try {
    if (isset($_POST['supprimer'])) {
        include ("../functions/connectionToDb.php");

        // Utilisation de htmlspecialchars pour les données sensibles
        $id_commentaire = htmlspecialchars($_POST['id_commentaire']);
        $id_article = htmlspecialchars($_POST['id_article']);
        $title = htmlspecialchars($_POST['title']);
        $article_content = $_POST['article_content'];
        $user_id = htmlspecialchars($_POST['user_id']);
        $id_admins = htmlspecialchars($_POST['admins_id']);
        $created_at = date('Y-m-d H:i:s');

        // Préparation de la requête de suppression
        $delete_query = $connection->prepare("DELETE FROM comments WHERE id = :id_commentaire");
        $delete_query->bindParam(':id_commentaire', $id_commentaire);
        $delete_query->execute();

        // Stockage des informations nécessaires dans la session
        $_SESSION['id-article'] = $id_article;
        $_SESSION['title'] = $title;
        $_SESSION['article-content'] = $article_content;
        $_SESSION['created_at'] = $created_at;
        $_SESSION['id_admins'] = $id_admins;

        // Redirection vers la page de visualisation de l'article
        header('Location: view_article.php');
        exit();
    }
} catch (PDOException $erreur) {
    echo 'Connexion échouée. Erreur : ' . $erreur->getMessage();
}
?>
