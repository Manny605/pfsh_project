<?php

session_start();
// var_dump($_SESSION);
include '../../../const/functions.php';

$articles = getAllArticles();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin : Articles</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 56px;
        }
        @media (min-width: 768px) {
            body {
                padding-top: 72px;
            }
        }
        @media (max-width: 480px) {
            .mobile-only{
                display: none;
            }
        }
    </style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Administrateur</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Tableau de bord</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="articles.php">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../categories/categories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../utilisateurs/utilisateurs.php">Utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../const/deconnexion.php">Deconnecter</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col">
                        <h2>Liste des Articles</h2>
                    </div>
                </div>
                <div class="row justify-content-end mb-4">
                    <div class="col-auto">
                        <a href="new_article.php" class="btn btn-primary ml-auto ">Ajouter</a>
                    </div>
                </div>

                <hr>

                <?php
                    if (isset($_GET['success_ajout']) && $_GET['success_ajout'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                            L\'article a été ajouté avec succès.
                        </div>';
                    } elseif (isset($_GET['error_ajout'])) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Une erreur inconnue s\'est produite.';
                        echo '</div>';
                    }

                    if (isset($_GET['success_modif']) && $_GET['success_modif'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                            L\'article a été mis à jour avec succès.
                        </div>';
                    }
                    // } elseif (isset($_GET['error_modif'])) {
                    //     echo '<div class="alert alert-danger" role="alert">';
                    //     echo 'Une erreur inconnue s\'est produite.';
                    //     echo '</div>';
                    // }
                    if (isset($_GET['success_supp']) && $_GET['success_supp'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                            L\'article a été supprimé avec succès.
                        </div>';
                    } elseif (isset($_GET['error_supp'])) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Une erreur inconnue s\'est produite.';
                        echo '</div>';
                    }
                ?>

                <!-- Main Content -->
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="mobile-only"></th>
                            <th>Titre</th>
                            <th>Date de publication</th>
                            <th>Auteur</th>
                            <th class="mobile-only">Categorie</th>
                            <th class="mobile-only">Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $increment = 1; ?>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td class="mobile-only"><?php echo $increment; ?></td>
                                <td><?php echo substr($article['titre'], 0, 90); ?>...</td>
                                <td><?php echo date('Y-m-d H:i', strtotime($article['date_publication'])); ?></td>
                                <td><?php echo $article['nom_auteur']; ?></td>
                                <td class="mobile-only"><?php echo $article['nom_categorie']; ?></td>
                                <td class="mobile-only"><?php echo substr($article['image'], 0, 20); ?>...</td>
                                <td class="row">
                                    <a href="" data-toggle="modal" data-target="#deleteModal<?php echo $article['id']; ?>"><i class="fas fa-trash text-danger"></i></a>
                                    <a href="modifier_article.php?id=<?php echo $article['id']; ?>"><i class="px-4 fas fa-edit text-success"></i></a>                                </td>
                            </tr>
                            <?php $increment++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Delete pour chaque article -->
    <?php foreach($articles as $index => $article): ?>
        <div class="modal fade" id="deleteModal<?php echo $article['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Supprimer l'article</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer cet article ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <a href="supprimer_article.php?id=<?php echo $article['id']; ?>" class="btn btn-danger">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>



    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>