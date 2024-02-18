<?php
session_start();

// Vérification des données du formulaire
if(isset($_POST['id'], $_POST['titre'], $_POST['contenu'], $_POST['categorie_id'])) {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $categorie_id = $_POST['categorie_id'];
    
    // Vérification de l'existence et de la validité de la variable $_FILES['image']
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Définir le chemin où vous souhaitez enregistrer l'image
        $upload_directory = 'images/'; // Chemin relatif

        $image = $upload_directory . $_FILES['image']['name'];
        
        // Déplacer l'image téléchargée vers le répertoire de destination
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    } else {
        $image = ''; // Si aucune image n'a été téléchargée ou si une erreur s'est produite
    }

    // Inclusion du fichier de connexion et des fonctions
    include '../../../const/functions.php';
    $connect = connect();

    // Requête SQL sécurisée pour mettre à jour l'article
    $sql = "UPDATE articles SET titre = ?, contenu = ?, categorie_id = ?, image = ? WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssisi", $titre, $contenu, $categorie_id, $image, $id);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        header("Location: articles.php?id=$id&success_modif=ok");
    } else {
        header("Location: articles.php?id=$id&error_modif=error1");
    }
} else {
    // Redirection si les données du formulaire ne sont pas correctement définies
    // header("Location: articles.php?id=$id&error_modif=error2");
}
?>

