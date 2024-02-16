<?php

session_start();

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Inclusion du fichier de connexion et des fonctions
    include '../../../const/functions.php';
    $connect = connect();

    // Requête SQL sécurisée pour supprimer l'article
    $sql = "DELETE FROM users WHERE id_user = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        // Redirection vers la page des articles avec un message de succès
        header("Location: utilisateurs.php?success_supp=ok");
    } else {
        // Redirection vers la page des articles avec un message d'erreur
        header("Location: utilisateurs.php?error_supp=error1");
    }
} else {
    // Redirection vers la page des articles si l'ID n'est pas valide ou n'est pas fourni
    header("Location: utilisateurs.php?error_supp=error2");
}
?>
