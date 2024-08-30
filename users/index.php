<?php
// Initialisation de la session
session_start();
include ("../functions/connectionToDb.php");
global $connection;
$title = "Accueil";
include ("../commonFiles/header.php");
include ("../commonFiles/navbar.php");
?>
<style>
    /* Style pour la page d'accueil */
    body {
        background: linear-gradient(to right, #ff758c, #ff7eb3);
        color: #fff;
        padding-top: 80px; /* Hauteur de la navbar fixe (à ajuster selon vos besoins) */
    }

    .jumbotron {
        background: rgba(255, 255, 255, 0.8);
        color: #333;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: fadeInDown 1s;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        border: none;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        color: #333;
        animation: fadeInUp 1s;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-title {
        color: #ff758c;
    }

    .card-text {
        color: #555;
    }

    .btn-primary {
        background-color: #ff7eb3;
        border-color: #ff7eb3;
    }

    .btn-primary:hover {
        background-color: #ff758c;
        border-color: #ff758c;
    }
</style>
</head>
<body>

<div class="container">
    <div class="jumbotron text-center p-2">
        <h1 class="display-4">Bienvenue sur notre site de commentaires!</h1>
        <p class="lead">Partagez vos opinions et découvrez ce que les autres pensent.</p>
        <hr class="my-4">
        <p>Vous pouvez lire les derniers articles ci-dessous ou publier vos propres commentaires.</p>
        <a class="btn btn-primary btn-lg" href="view_articles.php" role="button">Publier un commentaire</a>
    </div>
    <br><br><br>

    <div class="row">
        <?php
        $sql = 'SELECT * FROM aricles ORDER BY id DESC LIMIT 6';
        $req = $connection->query($sql);
        $articles = $req->fetchAll();

        foreach ($articles as $article): ?>
            <div class="col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                        <div class="embed-responsive embed-responsive-16by9 mb-3">
                            <?= (str_starts_with($article['content'], '<iframe')) ? $article['content'] : htmlspecialchars(substr($article['content'], 0, 100)) ?>...
                        </div>
                        <form action='view_article.php' method='post'>
                            <input type='hidden' name='id_article' value='<?= htmlspecialchars($article['id']) ?>'>
                            <input type='hidden' name='title' value='<?= htmlspecialchars($article['title']) ?>'>
                            <input type='hidden' name='created_at' value='<?= htmlspecialchars($article['created_at']) ?>'>
                            <input type='hidden' name='id_admins' value='<?= htmlspecialchars($article['id_admins']) ?>'>
                            <input type='hidden' name='content' value='<?= htmlspecialchars($article['content']) ?>'>
                            <input type='submit' name='more' value='Lire Plus' class="btn btn-primary" style="margin-left: 25%; width: 45%">
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
include('../commonFiles/footer.php');
?>
