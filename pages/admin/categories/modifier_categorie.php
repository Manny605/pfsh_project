<?php
session_start();

if(isset($_POST['id_categorie']) && isset($_POST['nom_categorie']) && isset($_POST['nom_categorie_ar']) && isset($_POST['nom_categorie_ang'])) {
    $id_categorie = $_POST['id_categorie'];
    $nom_categorie = $_POST['nom_categorie'];
    $nom_categorie_ar = $_POST['nom_categorie_ar'];
    $nom_categorie_ang = $_POST['nom_categorie_ang'];

    include '../../../const/functions.php';
    $connect = connect();

    $sql = "UPDATE categories SET nom_categorie = ?, nom_categorie_ar = ?, nom_categorie_ang = ? WHERE id_categorie = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("sssi", $nom_categorie, $nom_categorie_ar, $nom_categorie_ang ,$id_categorie);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        header("Location: categories.php?success_modif=ok");
    } else {
        header("Location: categories.php?error_modif=error1");
    }
} else {
    header("Location: categories.php?error_modif=error2");
}
?>
