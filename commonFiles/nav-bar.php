<?php
session_start();
if (!isset($_SESSION['admin-name'])) { ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../admins/Accueil">
                <img src="../icons/icon.png" alt="Logo SystemeDeCommentaires.Com" class="logo-img" style="width: 50px; height: 50px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../admins/accueil.php">Accueil</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } else { ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../admins/accueil.php">
                <img src="../icons/icon.png" alt="Logo SystemeDeCommentaires.Com" class="logo-img img-thumbnail" style="width: 50px; height: 50px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../admins/accueil.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../admins/viewArticles.php">Mes Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../admins/add_article.php">Ajouter un article</a>
                    </li>
                    <li class="nav-item" style="margin-right: 3px">
                        <a class="nav-link" href="../admins/account.php"><?= $_SESSION['admin-name'] ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } ?>
