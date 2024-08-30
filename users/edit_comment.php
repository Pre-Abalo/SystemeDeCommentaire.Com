<?php
session_start();
global $connection;
$title = "Modifier un commentaire";
include ("../commonFiles/header.php");
include_once('../commonFiles/navbar.php');
include("../functions/connectionToDb.php");

try {
    if (isset($_SESSION['user_id'])){
        if (isset($_POST['modifier'])){?>
            <div class="container mt-5">
                <div class="row mt-5">
                    <div class="col-6 offset-md-3 mt-5">
                        <form action="./edit_comment1.php" method="post">
                            <div class="form-group" style="display: inline;">
                                <label for="commentaire-contenu"></label>
                                <textarea class="form-control" id="commentaire-contenu" name="comment" rows="3" required placeholder="Laisser un commentaire"><?= $_POST['comment_content'] ?></textarea>
                            </div>
                            <input type="hidden" name="id_commentaire" value="<?= $_POST['id_commentaire'] ?>">
                            <input type="submit" name="editer" value="Editer" class="btn btn-primary" style="display: inline; margin-left: 33.3%; float: left">
                        </form>
                    </div>
                </div>
            </div>
        <?php }
    } else{
        header('Location: login.php');
    }
} catch (PDOException $erreur) {
    echo 'Connexion échouée. Erreur : ' . $erreur->getMessage();
}
?>
