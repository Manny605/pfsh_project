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
    if (isset($_POST["nom_categorie"])) {
        // Récupère les données du formulaire
        $nom_categorie = $_POST["nom_categorie"];
        
        // Insérer l'article dans la base de données en utilisant la fonction insertArticle
        insertCategorie($nom_categorie);
        
        // Redirigez l'utilisateur vers une page de confirmation ou une autre page appropriée
        header("Location: categories.php?success_ajout=ok");
        exit();

    } else {
        // Rediriger vers une page d'erreur si des données sont manquantes
        header("Location: categories.php?error_ajout=error1");
        exit();
    }
    
} else {
    // Rediriger vers une page d'erreur si la requête n'est pas de type POST
    header("Location: categories.php?error_ajout=error2");
    exit();
}

?>
