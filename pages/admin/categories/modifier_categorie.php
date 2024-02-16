<?php
session_start();

if(isset($_POST['id_categorie']) && isset($_POST['nom_categorie'])) {
    $id_categorie = $_POST['id_categorie'];
    $nom_categorie = $_POST['nom_categorie'];

    include '../../../const/functions.php';
    $connect = connect();

    $sql = "UPDATE categories SET nom_categorie = ? WHERE id_categorie = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("si", $nom_categorie, $id_categorie);
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
