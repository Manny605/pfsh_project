<?php
require_once "../const/functions.php";

$categories = getAllCategories();

if(isset($_GET['id']) && isset($_GET['categorie_id'])) {

    $article_id = $_GET['id'];
    $article = getArticleById($article_id);

    $categorie_id = $_GET['categorie_id'];
    $articles_categorie = getArticlesByCategorie($categorie_id);
    
    if($article) {
        $titre = $article['titre'];
        $categorie_nom = isset($articles_categorie[0]['nom_categorie']) ? $articles_categorie[0]['nom_categorie'] : "";
?>

<!doctype html>
<html lang="en">
<head>
    <title><?php echo $titre ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <!-- Utilisation de Bootstrap CSS personnalisé pour éviter les couleurs jaune et vert -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* Personnalisation des couleurs */
        body {
            background-color: #f8f9fa; /* Couleur de fond gris clair */
            color: #343a40; /* Couleur de texte foncée */
        }
        header {
            background-color: #212529; /* Couleur de fond foncée pour le header */
            color: #ffffff; /* Couleur de texte claire */
            padding: 20px;
        }
        main {
            padding: 20px;
        }
        footer {
            background-color: #212529; /* Couleur de fond foncée pour le footer */
            color: #ffffff; /* Couleur de texte claire */
            padding: 20px;
        }
        .sidebar {
            background-color: #f0f0f0; /* Couleur de fond de la barre latérale */
            padding: 20px;
        }
    </style>
</head>

<body>
    
    <div>
        <?php include '../components/navbar.php' ?>
    </div>

    <main>
        <div class="container-fluid mt-5">
            <div class="row">

            <div class="col-md-3">
                <div class="sidebar vh-100">
                    <h3>Derniers articles <?php echo $categorie_nom ?></h3>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                        // Vérifier si $articles_categorie est défini avant de l'utiliser
                        if(isset($articles_categorie) && is_array($articles_categorie)) {
                            foreach ($articles_categorie as $articles_categorie) {
                                $titre = $articles_categorie['titre'];
                                // Vérifier si la longueur du titre dépasse 40 caractères
                                if (strlen($titre) > 40) {
                                    // Si c'est le cas, tronquer le titre et ajouter des points de suspension
                                    $titre = substr($titre, 0, 40) . '...';
                                }
                                echo "<li><a href='articles_par_id.php?id=" . $articles_categorie['id'] . "&categorie_id=" . $categorie_id . "' class='dropdown-item'>" . $titre . "</a></li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>


                <div class="col-md-9">
                    <h2 class="mb-4">Articles <?php echo $categorie_nom ?></h2>
                    
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title py-4"><?php echo $article['titre'] ?></h2>
                            <hr>
                            <p class="card-text py-5"><?php echo $article['contenu'] ?></p>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p>Date de publication : <?php echo $article['date_publication'] ?></p>
                                <p>Auteur : <?php echo $article['nom_auteur'] ?></p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>


    <!-- Utilisation des scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
<?php
    } else {
        // Si aucun article n'est trouvé pour cet ID
        echo "Aucun article trouvé pour cet ID.";
    }
} else {
    // Si l'ID de l'article n'est pas spécifié dans l'URL
    echo "ID d'article non spécifié.";
}
?>
