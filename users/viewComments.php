<?php
// Initialisation de la session
session_start();
include ("../functions/connectionToDb.php");
global $connection;
$title = "Articles";
include ("../commonFiles/header.php");
include ("../commonFiles/navbar.php");


$sql = 'SELECT * FROM aricles ORDER BY id DESC';

$req = $connection->query($sql);
$articles = $req->fetchAll();
?>

<style>
    /* Ajustement de la marge supérieure pour éviter que le contenu ne soit caché sous la navbar fixe */
    body {
        padding-top: 80px; /* Hauteur de la navbar fixe (à ajuster selon vos besoins) */
    }

    /* Style pour chaque événement */
    .event-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff; /* Fond blanc pour chaque carte d'événement */
    }

    .event-card img {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        margin-bottom: 15px;
    }
</style>

<div class="container">
    <h1 class="text-center">ARTICLES</h1>

    <iframe width="560" height="315" src="https://www.youtube.com/embed/EKkzbbLYPuI?si=3KtMXIfd8AO9OY0d" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

    <div class="row">
        <?php foreach ($articles as $cle => $article):
            if (strpos($article['content'], '<iframe' == 0)){?>
                <div class="col-md-6 h-25">
                <div class="event-card">
                    <!--                    <img src="--><?php //= $article['image_article'] ?><!--" alt="--><?php //= $article['image'] ?><!--" class="img-fluid">-->
                    <h3><?= $article['title'] ?></h3>
                    <p><strong>Posté le :</strong> <?= $article['created_at'] ?></p>
                    <p><strong>Par :</strong> <?= $article['id_admins'] ?></p>
                    <!--                    <p>--><?php //= $article['content'] ?><!--</p>-->
                    <?= $article['content'] ?>
                    <form action='view_article.php' method='post'>
                        <input type='hidden' name='id_article' value='<?= $id_article = $article['id'] ?>'>
                        <input type='hidden' name='title' value='<?= $title = $article['title'] ?>'>
                        <!--                        <input type='hidden' name='image_article' value='--><?php //= $image_article = $article['image_article'] ?><!--'>-->
                        <input type='hidden' name='created_at' value='<?= $created_at = $article['created_at'] ?>'>
                        <input type='hidden' name='id_admins' value='<?= $admin_id = $article['id_admins'] ?>'>
                        <input type='hidden' name='content' value='<?= $content = $article['content'] ?>'>
                        <input type='submit' name='more' value='Lire' class="btn btn-warning" id='infos' style="margin-left: 25%; width: 45%">
                    </form>
                </div>
                </div><?php
            }else{
                ?>
                <div class="col-md-6 h-25">
                    <div class="event-card">
                        <!--                    <img src="--><?php //= $article['image_article'] ?><!--" alt="--><?php //= $article['image'] ?><!--" class="img-fluid">-->
                        <h3><?= $article['title'] ?></h3>
                        <p><strong>Posté le :</strong> <?= $article['created_at'] ?></p>
                        <p><strong>Par :</strong> <?= $article['id_admins'] ?></p>
                        <!--                    <p>--><?php //= $article['content'] ?><!--</p>-->
                        <form action='view_article.php' method='post'>
                            <input type='hidden' name='id_article' value='<?= $id_article = $article['id'] ?>'>
                            <input type='hidden' name='title' value='<?= $title = $article['title'] ?>'>
                            <!--                        <input type='hidden' name='image_article' value='--><?php //= $image_article = $article['image_article'] ?><!--'>-->
                            <input type='hidden' name='created_at' value='<?= $created_at = $article['created_at'] ?>'>
                            <input type='hidden' name='id_admins' value='<?= $admin_id = $article['id_admins'] ?>'>
                            <input type='hidden' name='content' value='<?= $content = $article['content'] ?>'>
                            <input type='submit' name='more' value='Lire' class="btn btn-warning" id='infos' style="margin-left: 25%; width: 45%">
                        </form>
                    </div>
                </div>
            <?php }endforeach; ?>
    </div>
</div>

<?php
include('../commonFiles/footer.php');
?>
