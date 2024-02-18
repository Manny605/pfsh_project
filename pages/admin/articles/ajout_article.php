<?php
session_start();
$id_user = $_SESSION['user_id'];
// Inclure le fichier de fonctions
include_once '../../../const/functions.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $titre = $_POST['titre'];
    $categorie_id = $_POST['categorie_id'];
    $id_user = $_POST['id_user'];
    $contenu = $_POST['contenu'];
    
    // Vérifier si une image a été téléchargée
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Récupérer le nom temporaire de l'image
        $image_tmp = $_FILES['image']['tmp_name'];
        
        // Définir l'emplacement de sauvegarde de l'image
        $image_destination = 'images/' . $_FILES['image']['name'];
        
        // Déplacer l'image téléchargée vers le répertoire de destination
        move_uploaded_file($image_tmp, $image_destination);
    } else {
        // Si aucune image n'a été téléchargée, définir l'emplacement de l'image comme vide
        $image_destination = '';
    }
    
    // Appeler la fonction insertArticle pour insérer l'article dans la base de données
    insertArticle($titre, $categorie_id, $id_user, $contenu, $image_destination);
    
    // Rediriger l'utilisateur vers une page de succès ou d'accueil
    header("Location: articles.php?success_ajout=ok");
    exit();
} else {
    // Rediriger l'utilisateur vers une page d'erreur ou d'accueil si le formulaire n'est pas soumis
    header("Location: articles.php?error_ajout=error");
    exit();
}
?>
