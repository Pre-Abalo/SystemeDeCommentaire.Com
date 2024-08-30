<?php
global $connection;
session_start();
$title = 'Compte';
include("../commonFiles/header.php");
include('../commonFiles/navbar.php');
include('../functions/connectionToDb.php');

if (isset($_SESSION['user_id'])){
// Requête SQL pour vérifier l'utilisateur dans la base de données
$query = $connection->prepare("SELECT * FROM users WHERE id = ?");
$query->execute([$_SESSION['user_id']]);
$user = $query->fetch(PDO::FETCH_ASSOC);

?>

<div class="container mt-5 pt-5">
    <h1 class="text-center"><?= $title ?></h1>

    <div class="card shadow p-4 mt-5">
        <h4 class="card-title">Informations de Compte</h4>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Votre Nom :</strong> <?= $_SESSION['username'] ?></li>
            <li class="list-group-item"><strong>Votre Adresse :</strong> <?= $_SESSION['email'] ?></li>
        </ul>
    </div>
    <?php
    if (isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header('location: view_articles.php');
    }
    ?>

    <form class="mt-4" action='' method='post'>
        <input class="btn btn-danger" type='submit' name='logout' value='Se Déconnecter'>
    </form>
</div>
<?php } else{
    header('Location: login.php');
}

?>

<?php
include("../commonFiles/footer.php");
?>
