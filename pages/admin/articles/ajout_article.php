<?php

session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id_user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../../../auth/login.php");
    exit();
}

// Inclure le fichier de fonctions contenant la fonction d'insertion
include '../../../const/functions.php';

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si toutes les données requises sont présentes
    if (isset($_POST["titre"]) && isset($_POST["categorie_id"]) && isset($_POST["id_user"]) && isset($_POST["contenu"])) {
        // Récupère les données du formulaire
        $titre = $_POST["titre"];
        $categorie_id = $_POST["categorie_id"];
        $id_user = $_POST["id_user"];
        $contenu = $_POST["contenu"];
        
        // Vérifie si une image a été téléchargée
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $image = $_FILES["image"]["name"];
            $image_tmp = $_FILES["image"]["tmp_name"];

            // Déplace l'image téléchargée vers le répertoire souhaité
            move_uploaded_file($image_tmp, "../../../images/" . $image);
        } else {
            $image = null; // Ou assignez un chemin par défaut pour une image par défaut
        }
        
        // Insérer l'article dans la base de données en utilisant la fonction insertArticle
        insertArticle($titre, $categorie_id, $id_user, $contenu, $image);
        
        // Redirigez l'utilisateur vers une page de confirmation ou une autre page appropriée
        header("Location: articles.php?success_ajout=ok");
        exit();
    } else {
        // Rediriger vers une page d'erreur si des données sont manquantes
        header("Location: articles.php?error_ajout=error1");
        exit();
    }
} else {
    // Rediriger vers une page d'erreur si la requête n'est pas de type POST
    header("Location: articles.php?error_ajout=error2");
    exit();
}

?>
