<?php
include ("../functions/connectionToDb.php");
global $connection;
$title = "Se Connecter";
include ("../commonFiles/header.php");

// Initialisation de la session
session_start();

// Vérification du formulaire de connexion
if (isset($_POST["submit"])) {
    $mail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $pass = $_POST['pass'];

    if ($mail && $pass) {

        // Requête SQL pour vérifier l'utilisateur dans la base de données
        $query = $connection->prepare("SELECT * FROM admins WHERE email = ?");
        $query->execute([$mail]);
        $admin = $query->fetch(PDO::FETCH_ASSOC);

        if ($admin && $pass == $admin['pass']) {
            // Utilisateur trouvé, enregistrement des informations de session
            session_regenerate_id(true);
            $_SESSION['admin-name'] = $admin['name'];
            $_SESSION['admin-email'] = $admin['email'];
            $_SESSION['admin-id'] = $admin['id'];
            // Redirection vers une page après la connexion
            header('Location: accueil.php');
            exit();
        } else {
            $error_message = 'Identifiants incorrects';
        }
    } else {
        $error_message = 'Veuillez remplir tous les champs';
    }
}
?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                // Affichage du message d'erreur s'il y en a un
                if (isset($error_message)) {
                    echo '<div class="alert alert-danger mt-5" role="alert">' . htmlspecialchars($error_message) . '</div>';
                }
                ?>
                <form method='post' action='index.php' autocomplete='on' class='mt-5'>
                    <fieldset class="border rounded p-5">
                        <legend class="text-center mb-4">
                            <h3 class="fw-bolder">SystemeDeCommentaires.Com</h3><br>
                            Connexion
                        </legend>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse mail :</label>
                            <input type='email' id='email' name='email' class="form-control" required='required'>
                        </div>
                        <div class="mb-3">
                            <label for="pass" class="form-label">Mot de passe :</label>
                            <input type='password' id='pass' name='pass' class="form-control" required='required'>
                        </div>
                        <div class="text-center">
                            <button type='submit' name='submit' class="btn btn-primary">Se connecter</button>
                        </div>
                        <div class="mt-3 text-center">
                            <p>Pas de compte ? <a href='signUp.php'>S'inscrire</a></p>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

<?php
include('../commonFiles/footer.php');
?>