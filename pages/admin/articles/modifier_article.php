<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../../index.php");
    exit();
}

include_once "../../../const/functions.php";

// Vérification de l'existence de l'ID d'article dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $article_id = $_GET['id'];
    // Récupération des détails de l'article
    $article_by_id = getArticleById($article_id);
}
$categories = getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin : Modification d'article</title>
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
                <?php if ($_SESSION['role'] !== 'auteur'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="../utilisateurs/utilisateurs.php">Utilisateurs</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../const/deconnexion.php">Deconnecter</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-1 mb-3">
    <div class="row w-100">
        <div class="col-md-12">
            <h2 class="mb-4">Modifier l'article</h2>

            <form action="traiter_modification_article.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titre">Titre :</label>
                    <input type="text" class="form-control" id="titre" name="titre" value="<?php echo htmlspecialchars($article_by_id['titre']); ?>">
                </div>
                <div class="form-group">
                    <label for="categorie_id">Catégorie :</label>
                    <select class="form-control" id="categorie_id" name="categorie_id">
                        <!-- Vous pouvez charger les catégories depuis la base de données ici -->
                        <option value="">Sélectionnez une catégorie</option>
                        <?php foreach ($categories as $categorie): ?>
                            <!-- Vérifiez si la catégorie correspond à celle de l'article pour la sélectionner par défaut -->
                            <option value="<?php echo $categorie['id_categorie']; ?>" <?php if($categorie['id_categorie'] == $article_by_id['categorie_id']) echo "selected"; ?>><?php echo $categorie['nom_categorie']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Input caché pour stocker l'ID de l'utilisateur -->
                <input type="hidden" name="id" value="<?php echo $article_by_id['id']; ?>">

                <div class="form-group">
                    <label for="contenu">Contenu :</label>
                    <textarea class="form-control" id="contenu" name="contenu" rows="15"><?php echo htmlspecialchars($article_by_id['contenu']); ?></textarea>
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
