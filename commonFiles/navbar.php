<?php
if (!isset($_SESSION['user_id'])) { ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../users/index.php">
                <img src="<?= $src ?? '../icons/icon.png' ?>" alt="Logo SystemeDeCommentaires.Com" class="logo-img img-thumbnail" style="width: 50px; height: 50px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $accueil ?? '../users/index.php' ?>">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $articles ?? '../users/view_articles.php' ?>">Voir les Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $log ?? '../users/login.php' ?>">Log In</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } else { ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../users/index.php">
                <img src="<?= $src ?? '../icons/icon.png' ?>" alt="Logo SystemeDeCommentaires.Com" class="logo-img img-thumbnail" style="width: 50px; height: 50px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $accueil ?? '../users/index.php' ?>">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $articles ?? '../users/view_articles.php' ?>">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder border p-2 rounded-5 bg-primary text-white" href="../users/account.php"><?= $_SESSION['username'] ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } ?>

<style>
    .navbar {
        transition: background-color 0.3s;
    }

    .navbar-brand {
        font-family: 'Lobster', cursive;
        font-size: 1.5em;
    }

    .navbar-nav .nav-link {
        font-size: 1.1em;
        margin-right: 15px;
        transition: color 0.3s, transform 0.3s;
    }

    .navbar-nav .nav-link:hover {
        color: #ff7eb3;
        transform: scale(1.1);
    }

    .navbar-nav .nav-item .nav-link.fw-bolder {
        background-color: #ff7eb3;
        color: white !important;
    }

    .navbar-nav .nav-item .nav-link.fw-bolder:hover {
        background-color: #ff758c;
    }

    @media (max-width: 992px) {
        .navbar-nav {
            text-align: center;
        }

        .navbar-nav .nav-link {
            margin-bottom: 10px;
        }
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
