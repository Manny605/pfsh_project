<?php

session_start();

// var_dump($_SESSION['id_user']);

$id_user = $_SESSION['id_user'];

include '../../../const/functions.php';

$categories = getAllCategories();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
        }
        @media (min-width: 768px) {
            body {
                padding-top: 72px;
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

    <div class="container mt-1 mb-3">
        <div class="row w-100">
            <div class="col-md-12">
                <h2 class="mb-4">Écrire un nouvel article</h2>
                <form action="ajout_article.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="titre">Titre :</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label for="categorie_id">Catégorie :</label>
                        <select class="form-control" id="categorie_id" name="categorie_id" required>
                            <!-- Vous pouvez charger les catégories depuis la base de données ici -->
                            <option value="">Sélectionnez une catégorie</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id_categorie']; ?>"><?php echo $category['nom_categorie']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" name="id_user" value="<?php echo $id_user ?>">

                    <div class="form-group">
                        <label for="contenu">Contenu :</label>
                        <textarea class="form-control" id="contenu" name="contenu" rows="15" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Image :</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
