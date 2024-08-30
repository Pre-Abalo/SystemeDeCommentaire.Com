<?php
global $connection;
$title = "S'inscrire";
include ("../commonFiles/header.php");

try {
    // Vérification des données du formulaire
    if ( isset($_POST['username'], $_POST['email'], $_POST['pass'], $_POST['cpass'])){
        include ("../functions/connectionToDb.php");
        // Vérification si l'email existe déjà dans la base de données
        $reqete_mail_existe = $connection->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $reqete_mail_existe->bindParam(':email', $_POST['email']);
        $reqete_mail_existe->execute();
        $email_count = $reqete_mail_existe->fetchColumn();

        if ($email_count > 0) {?>
            <script>
                alert('Cet email est déjà utilisé. Veuillez en choisir un autre.');
            </script>
            <?php
        } else {
            // Récupération des données du formulaire
            $name = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $pass = htmlspecialchars($_POST['pass']);// Hachage du mot de passe
            $cpass = htmlspecialchars($_POST['cpass']);
            $created_at = date('Y-m-d H:i:s');

            if ($_POST['pass'] === $cpass){
                // Préparation de la requête SQL à l'aide de marqueurs
                $sql = "INSERT INTO users (username, email, pass, created_at)
                                VALUES (:name, :email,:pass, :created_at)";

                $query = $connection->prepare($sql);

                // Liaison des marqueurs à des variables grâce à la méthode bindparam
                $query->bindParam(':name', $name);
                $query->bindParam(':email', $email);
                $query->bindParam(':pass', $pass);
                $query->bindParam(':created_at', $created_at);

                // Exécution de la requête
                $query->execute();
                echo 'Inscription réussie';

                // Création de la session pour maintenir l'utilisateur connecté
                session_start();
                // Récupération de l'ID du utilisateuricipant dernierement inséré
                $user_id = $connection->lastInsertId();

                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $pass;

                // Redirection vers la page d'accueil après l'inscription
                header('Location: login.php');
                exit();
            } else{?>
                <script>
                    alert('Incoherence De Mot De pass');
                </script>
                <?php
            }
        }
    }
} catch (PDOException $erreur) {
    echo 'Connexion échouée. Erreur : ' . $erreur->getMessage();
}
?>


<div class="container align-content-center">
    <div class="row justify-content-center">
        <div class="col-6 mt-5">
            <form action="./register" method="post">
                <fieldset class="border border-3 rounded p-5">
                    <legend class="align-content-center fw-bolder">SystemeDeCommentaires.Com</legend>
                    <div>
                        <label for="username">Nom d'utilisateur</label>
                        <input class="form-control" id="username" type="text" name="username" required>
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input class="form-control" id="email" type="email" name="email" required>
                    </div>
                    <div>
                        <label for="pass">Mot de passe</label>
                        <input class="form-control" id="pass" type="password" name="pass" required>
                    </div>
                    <div>
                        <label for="cpass">Confirmation de Mot De passe</label>
                        <input class="form-control" id="cpass" type="password" name="cpass" required>
                    </div>
                    <div class="justify-content-center">
                        <button class="btn btn-primary">S'enregistrer</button>
                    </div>
                </fieldset>

            </form>
        </div>
    </div>
</div>

