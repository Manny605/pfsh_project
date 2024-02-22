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
    if (isset($_POST["prenom"]) && isset($_POST["nom"]) && isset($_POST["nom_utilisateur"]) && isset($_POST["mot_de_passe"]) && isset($_POST['role'])) {
        // Récupère les données du formulaire
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $nom_utilisateur = $_POST["nom_utilisateur"];
        $mot_de_passe = $_POST["mot_de_passe"];
        $role = $_POST['role'];
        
        // Insérer l'article dans la base de données en utilisant la fonction insertArticle
        insertUser($prenom,$nom,$nom_utilisateur,$mot_de_passe, $role);
        
        // Redirigez l'utilisateur vers une page de confirmation ou une autre page appropriée
        header("Location: utilisateurs.php?success_ajout=ok");
        exit();

    } else {
        // Rediriger vers une page d'erreur si des données sont manquantes
        header("Location: utilisateurs.php?error_ajout=error1");
        exit();
    }
    
} else {
    // Rediriger vers une page d'erreur si la requête n'est pas de type POST
    header("Location: utilisateurs.php?error_ajout=error2");
    exit();
}

?>
