<?php
global $connection;
$title = "Ajouter un article";
include ('../commonFiles/header.php');
include ('../commonFiles/nav-bar.php');
include ("../functions/connectionToDb.php");

try {
    // Vérification des données du formulaire
    if (isset($_POST['title'], $_POST['content'], $_FILES['uploadedImage'])) {

        // Vérifie si le fichier a été téléchargé sans erreur.
        if ($_FILES['uploadedImage']['error'] == 0) {

            $fileTmpPath = $_FILES['uploadedImage']['tmp_name'];
            $fileName = $_FILES['uploadedImage']['name'];
            $fileSize = $_FILES['uploadedImage']['size'];
            $fileType = $_FILES['uploadedImage']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Extensions autorisées
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

            // Vérifie si le fichier a une extension autorisée
            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Vérifie si le fichier est une image réelle
                $check = getimagesize($fileTmpPath);
                if ($check !== false) {
                    // Définir un dossier de destination pour les fichiers téléchargés
                    $uploadFileDir = '../images/';
                    $dest_path = $uploadFileDir . $fileName;

                    // Vérifiez si le dossier de destination existe, sinon le créer
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0777, true);
                    }

                    // Déplacer le fichier téléchargé vers son emplacement final
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $message = 'Le fichier est téléchargé avec succès.';

                        // Récupération des données du formulaire
                        $title = htmlspecialchars($_POST['title']);
                        $image = htmlspecialchars($fileName); // Stocker le nom du fichier dans la base de données
                        $content = htmlspecialchars($_POST['content']);
                        $created_at = date('Y-m-d H:i:s');
                        $admin_id = $_SESSION['admin-id'];

                        $article_exist = $connection->prepare("SELECT COUNT(*) FROM aricles WHERE title = :title");
                        $article_exist->bindParam(':title', $title);
                        $article_exist->execute();
                        $article_count = $article_exist->fetchColumn();

                        if ($article_count > 0) {
                            $message = 'Cet article existe déjà.';
                        } else {
                            // Préparation de la requête SQL à l'aide de marqueurs
                            $sql = "INSERT INTO aricles (title, image, content, created_at, id_admins)
                                    VALUES (:title, :image, :content, :created_at, :id_admin)";

                            $query = $connection->prepare($sql);

                            // Liaison des marqueurs à des variables grâce à la méthode bindparam
                            $query->bindParam(':title', $title);
                            $query->bindParam(':image', $image);
                            $query->bindParam(':content', $content);
                            $query->bindParam(':created_at', $created_at);
                            $query->bindParam(':id_admin', $admin_id);

                            // Exécution de la requête
                            $query->execute();
                            $message = 'Ajout réussi';

                            $_SESSION['article-title'] = $title;
                            $_SESSION['article-content'] = $content;

                            // Redirection vers la page d'accueil après l'inscription
                            // header('Location: viewArticles.php');
                            // exit();
                        }
                    } else {
                        $message = 'Il y a eu un problème lors du téléchargement du fichier.';
                    }
                } else {
                    $message = 'Le fichier téléchargé n\'est pas une image.';
                }
            } else {
                $message = 'Le type de fichier n\'est pas autorisé. Seules les images (jpg, jpeg, png, gif) sont autorisées.';
            }
        } else {
            $message = 'Erreur lors du téléchargement du fichier. Veuillez réessayer.';
        }
    }
} catch (PDOException $erreur) {
    $message = 'Connexion échouée. Erreur : ' . $erreur->getMessage();
}
?>

<br><br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 mt-5">
            <?php
            // Affichage du message d'erreur ou de succès
            if (isset($message)) {
                echo '<div class="alert mt-5" role="alert">' . htmlspecialchars($message) . '</div>';
            }
            ?>
            <fieldset>
                <legend class="text-center">Ajouter un Article</legend>
                <form action="./add_article.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="article-titre">Titre :</label>
                        <input type="text" class="form-control" id="article-titre" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="article-contenu">Contenu :</label>
                        <textarea class="form-control" id="article-contenu" name="content" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="uploadedImage">Choisir un fichier:</label>
                        <input type="file" class="form-control" id="uploadedImage" name="uploadedImage" accept="image/*" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Ajouter l'article</button>
                </form>
            </fieldset>
        </div>
    </div>
</div>

<?php
include ("../commonFiles/footer.php");
?>
