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
            background: linear-gradient(to right, #fbc2eb, #a6c1ee);
            color: #333;
        }

        .event-card {
            border: none;
            border-radius: 15px;
            padding: 20px;
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

        .event-card img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .card-title {
            color: #ff758c;
        }

        .card-text {
            color: #555;
        }

        .btn-warning {
            background-color: #ff7eb3;
            border-color: #ff7eb3;
        }

        .btn-warning:hover {
            background-color: #ff758c;
            border-color: #ff758c;
        }

        .text-center {
            margin-bottom: 30px;
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
    </style>
    </head>
<body>

<div class="container">
    <h1 class="text-center">ARTICLES</h1>
    <div class="row">
        <?php foreach ($articles as $article): ?>
            <div class="col-md-6">
                <div class="event-card">
                    <?php if (str_starts_with($article['content'], '<iframe')): ?>
                        <div class="embed-responsive embed-responsive-16by9 mb-3" style="margin-left: 5%">
                            <?= $article['content'] ?>
                        </div>
                        <h3 class="card-title"><?= htmlspecialchars($article['title']) ?></h3>
                        <p><strong>Posté le :</strong> <?= htmlspecialchars($article['created_at']) ?></p>
                        <p><strong>Type : VIDEO</strong></p>
                    <?php else: ?>
                        <img src="../images/<?= $article['image'] ?>" alt="Image de l'article" height="500px" class="img-fluid">
                        <h3 class="card-title"><?= htmlspecialchars($article['title']) ?></h3>
                        <p><strong>Posté le :</strong> <?= htmlspecialchars($article['created_at']) ?></p>
                        <p><strong>Par :</strong> <?= htmlspecialchars($article['id_admins']) ?></p>
                        <p class="card-text"><?= htmlspecialchars(substr($article['content'], 0, 100)) ?>...</p>
                    <?php endif; ?>
                    <form action='view_article.php' method='post'>
                        <input type='hidden' name='id_article' value='<?= htmlspecialchars($article['id']) ?>'>
                        <input type='hidden' name='title' value='<?= htmlspecialchars($article['title']) ?>'>
                        <input type='hidden' name='created_at' value='<?= htmlspecialchars($article['created_at']) ?>'>
                        <input type='hidden' name='id_admins' value='<?= htmlspecialchars($article['id_admins']) ?>'>
                        <input type='hidden' name='content' value='<?= htmlspecialchars($article['content']) ?>'>
                        <input type='submit' name='more' value='Lire' class="btn btn-warning" style="width: 100%">
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php
include('../commonFiles/footer.php');
?>
