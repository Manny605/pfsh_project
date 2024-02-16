<?php
session_start();

// Vérification des données du formulaire
if(isset($_POST['id_user'], $_POST['prenom'], $_POST['nom'], $_POST['nom_utilisateur'], $_POST['mot_de_passe'])) {
    $id_user = $_POST['id_user'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];
    
    // Inclusion du fichier de connexion et des fonctions
    include '../../../const/functions.php';
    $connect = connect();

    // Requête SQL sécurisée pour mettre à jour l'article
    $sql = "UPDATE users SET prenom = ?, nom = ?, nom_utilisateur = ?, mot_de_passe = ? WHERE id_user = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssssi", $prenom, $nom, $nom_utilisateur, $mot_de_passe, $id_user);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        header("Location: utilisateurs.php?id=$id_user&success_modif=ok");
    } else {
        header("Location: utilisateurs.php?id=$id_user&error_modif=error1");
    }
}
?>
