<?php
session_start();
global $connection;
$title = "Commenter ";
include ("../commonFiles/header.php");
include ("../commonFiles/navbar.php");

try {
    if (isset($_SESSION['user_id'])){
        // Vérification des données du formulaire
        if (isset($_POST['comment'])){
            include ("../functions/connectionToDb.php");
            // Récupération des données du formulaire
            $comment = htmlspecialchars($_POST['comment']);
            $title = htmlspecialchars($_POST['title']);
            $article_content = $_POST['article_content'];
            $created_at = date('Y-m-d H:i:s');
            $id_article = $_POST['id_article'];
            $user_id = $_POST['user_id'];
            $id_admins = $_POST['admins_id'];
            // Préparation de la requête SQL à l'aide de marqueurs
            $sql = "INSERT INTO comments (content, created_at, id_aricles, id_users)
                                VALUES (:content, :created_at,:id_article, :id_user)";

            $query = $connection->prepare($sql);

            // Liaison des marqueurs à des variables grâce à la méthode bindparam
            $query->bindParam(':content', $comment);
            $query->bindParam(':created_at', $created_at);
            $query->bindParam(':id_article', $id_article);
            $query->bindParam(':id_user', $user_id);

            // Exécution de la requête
            $query->execute();
            echo 'Commentaire posté avec succès';

            // Récupération de l'ID du utilisateuricipant dernierement inséré
            $id_comment = $connection->lastInsertId();

            $_SESSION['id-article'] = htmlspecialchars($_POST['id_article']);
            $_SESSION['title'] = $title;
            $_SESSION['article-content'] = $article_content;
            $_SESSION['created_at'] = $created_at;
            $_SESSION['id_admins'] = $id_admins;

            $_SESSION['comment-id'] = $id_comment;
            $_SESSION['comment-date'] = date('Y-m-d H:i:s');

            // Redirection vers la page d'accueil après l'inscription
            header("Location: view_article.php");
            exit(); // Assure que le script s'arrête après la redirection

        }
    } else{
        header('Location: login.php');
    }
} catch (PDOException $erreur) {
    echo 'Connexion échouée. Erreur : ' . $erreur->getMessage();
}
