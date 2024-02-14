<?php
require_once "../const/functions.php";

$categories = getAllCategories();
$AllArticles = getAllArticles();

if(isset($_GET['id'])) {

    $article_id = $_GET['id'];
    $Article_by_id = getArticleById($article_id);
    
    if($Article_by_id) {
        $titre = $Article_by_id['titre'];
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
                    <h3>Les derniers articles</h3>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php
                            if(isset($AllArticles)) {
                                // Parcourez tous les articles et affichez leurs titres dans la barre latérale
                                foreach ($AllArticles as $article) {
                                    $titres = $article['titre'];
                                    // Vérifiez si la longueur du titre dépasse 40 caractères
                                    if (strlen($titres) > 40) {
                                        // Si oui, tronquez le titre et ajoutez des points de suspension
                                        $titres = substr($titres, 0, 40) . '...';
                                    }
                                    echo "<li><a href='article_id.php?id=" . $article['id'] . "' class='dropdown-item'>" . $titres . "</a></li>";
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>



                <div class="col-md-9">
                    <h2 class="mb-4">Article</h2>
                    
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title py-4"><?php echo $Article_by_id['titre'] ?></h2>
                            <hr>
                            <p class="card-text py-5"><?php echo $Article_by_id['contenu'] ?></p>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p>Date de publication : <?php echo $Article_by_id['date_publication'] ?></p>
                                <p>Auteur : <?php echo $Article_by_id['nom_auteur'] ?></p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Mon site d'articles</p>
    </footer>

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
