<?php
ob_start();
global $connection;
session_start();
$title = $_POST['title'] ?? 'Lire Plus';
include_once('../commonFiles/header.php');
include_once('../commonFiles/navbar.php');
include("../functions/connectionToDb.php");

if (($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['more'])) ||
    (isset($_SESSION['title']) && isset($_SESSION['id-article']) && isset($_SESSION['id_admins']))) {

    $id_article = $_POST['id_article'] ?? $_SESSION['id-article'];
    $title = $_POST['title'] ?? $_SESSION['title'];
    $created_at = $_POST['created_at'] ?? $_SESSION['created_at'];
    $id_admins = $_POST['id_admins'] ?? $_SESSION['id_admins'];
    $content = $_POST['content'] ?? $_SESSION['article-content'];
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mt-5 shadow-lg border-0">
                    <div class="card-body">
                        <h5 class="card-title text-center text-bg-success py-3 rounded"><?= htmlspecialchars($title) ?></h5>
                        <div class="d-flex justify-content-between mt-3">
                            <p class="card-text"><strong>Posté le :</strong> <?= htmlspecialchars($created_at) ?></p>
                            <p class="card-text"><strong>Par :</strong> <?= htmlspecialchars($id_admins) ?></p>
                        </div>
                        <p class="card-text mt-4" style="margin-left: 13%"><?= $content ?></p>
                        <form method="post" action="addComment.php" class="mt-4">
                            <input type="hidden" name="id_article" value="<?= htmlspecialchars($id_article) ?>">
                            <input type="hidden" name="title" value="<?= htmlspecialchars($title) ?>">
                            <input type="hidden" name="article_content" value="<?= htmlspecialchars($content) ?>">
                            <input type="hidden" name="user_id" value="<?=$_SESSION['user_id'] ?? null ?>">
                            <input type="hidden" name="admins_id" value="<?= htmlspecialchars($id_admins) ?>">
                            <div class="form-group">
                                <label for="commentaire-contenu"></label>
                                <textarea class="form-control" id="commentaire-contenu" name="comment" rows="3" required placeholder="Laisser un commentaire"></textarea>
                            </div>
                            <button type="submit" name="commenter" class="btn btn-primary btn-block mt-3">Poster</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 mb-5">
            <div class="col-md-8 offset-md-2">
                <h3 class="text-center">Commentaires</h3>
                <?php
                $query = $connection->prepare("SELECT * FROM comments WHERE id_aricles = ? order by id desc");
                $query->execute([$id_article]);
                $comments = $query->fetchAll();

                foreach ($comments as $comment) {
                    $query = $connection->prepare("SELECT * FROM users WHERE id = ?");
                    $query->execute([$comment['id_users']]);
                    $user = $query->fetch();

                    if ($user) {
                        $username = htmlspecialchars($user['username']);
                        $comment_content = htmlspecialchars($comment['content']);
                        $comment_id = htmlspecialchars($comment['id']);
                        $user_id = $_SESSION['user_id'] ?? null;
                        ?>
                        <div class="card mt-3 border-0 shadow-sm">
                            <div class="card-body">
                                <p><i><?= $comment_content ?></i></p>
                                <?php if (isset($user_id) && $user['id'] == $user_id) { ?>
                                    <div class="d-flex justify-content-end mt-2">
                                        <form action="edit_comment.php" method="post" class="me-2">
                                            <input type="hidden" name="id_commentaire" value="<?= $comment_id ?>">
                                            <input type="hidden" name="comment_content" value="<?= $comment_content ?>">
                                            <input type="submit" name="modifier" value="Modifier" class="btn btn-link text-primary p-0">
                                        </form>
                                        <form action="deleteComment.php" method="post">
                                            <input type="hidden" name="id_commentaire" value="<?= $comment_id ?>">
                                            <input type="hidden" name="id_article" value="<?= htmlspecialchars($id_article) ?>">
                                            <input type="hidden" name="title" value="<?= htmlspecialchars($title) ?>">
                                            <input type="hidden" name="article_content" value="<?= htmlspecialchars($content) ?>">
                                            <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                            <input type="hidden" name="admins_id" value="<?= htmlspecialchars($id_admins) ?>">
                                            <input type="submit" name="supprimer" value="Supprimer" class="btn btn-link text-danger p-0 ms-2">
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <p class="text-end mt-3 mb-0">Posté par : <strong><?= $username ?></strong></p>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <?php
}

include("../commonFiles/footer.php");

ob_end_flush();
?>
<style>
    .card {
        background-color: #f8f9fa;
    }

    .card-title {
        background-color: #28a745;
        color: white;
        padding: 10px;
        border-radius: 0.25rem;
        font-size: 1.5rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .form-control {
        border-radius: 0.25rem;
    }

    .card-body p {
        font-size: 1rem;
    }

    .card-body {
        padding: 20px;
    }

    .btn-link {
        font-size: 0.9rem;
    }

    .container h3 {
        color: #6c757d;
    }

    .d-flex {
        align-items: center;
    }

    .shadow-sm {
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
    }

    .text-bg-success {
        background-color: #28a745 !important;
    }
</style>
