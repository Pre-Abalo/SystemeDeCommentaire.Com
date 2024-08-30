<?php
global $connection;
$title = "Mes Articles";
include ('../commonFiles/header.php');
include ('../commonFiles/nav-bar.php');
include ("../functions/connectionToDb.php");

$sql = "SELECT * FROM aricles WHERE id_admins = " . $_SESSION['admin-id'];
$req = $connection->query($sql);
$articles = $req->fetchAll();
?><br><br><br>
<div class="container mt-5">
    <h1 class="text-center mb-5"><?= $title ?></h1>
    <div class="row">
        <?php foreach ($articles as $article): ?>
            <div class="col-md-4 mb-5">
                <div class="card h-100">
                    <img src="../icons/icon.png" class="card-img-top" alt="Illustration article">
                    <div class="card-body">
                        <h5 class="card-title"><?= $article['title'] ?></h5>
                        <p class="card-text"><strong>Posté le :</strong> <?= $article['created_at'] ?></p>
                        <p class="card-text"><strong>Par :</strong> <?= $article['id_admins'] ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <form method="post" action="edit_article.php">
                                <input type="hidden" name="id_article" value="<?= $article['id'] ?>">
                                <button type="submit" name="Update" class="btn btn-primary">Modifier</button>
                            </form>
                            <form method="post" action="delete_article.php">
                                <input type="hidden" name="id_article" value="<?= $article['id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
include ("../commonFiles/footer.php");
?>
