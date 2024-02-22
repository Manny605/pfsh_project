<?php
require_once "../../const/functions.php";

$categories = getAllCategories();

if(isset($_GET['id']) && isset($_GET['categorie_id'])) {

    $article_id = $_GET['id'];
    $articleQ = getArticleById($article_id);

    $categorie_id = $_GET['categorie_id'];
    $articles_categorie = getArticlesByCategorieAng($categorie_id);
    
    if($articleQ) {
        $titre = $articleQ['titre'];
        $categorie_nom = isset($articles_categorie[0]['nom_categorie_ang']) ? $articles_categorie[0]['nom_categorie_ang'] : "";
    }
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
        @media (max-width: 992px) {
            .navbar-custom-young {
                flex-direction: row !important;
            }
        }
    </style>
</head>

<body>
    
    <div>
        <?php include '../../components/navbar_ang.php' ?>
    </div>

    <main>
        <div class="container-fluid mt-5">
            <div class="row">

                <div class="container mt-5">
                    <div class="row justify-content-md-center">
                        <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                            <h2 class="mb-4 display-5 text-center text-danger">Article</h2>
                            <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="d-flex flex-column">
                        <div class="col-md-12">
                            <a href="" class="gallery-link">
                                <img src="../admin/articles/<?php echo $articleQ['image']; ?>" alt="" class="w-100 img-responsive push-bit img-thumbnail" style="max-height: 400px;" />
                            </a>
                        </div>

                        <div class="my-3"></div>

                        <div class="col-md-12">
                            <div class="clearfix">
                                <div class="pull-right">
                                    <h2 class="text-uppercase"><strong><?php echo $articleQ['titre']; ?></strong></h2>
                                </div>

                                <div class="my-4"></div>

                                <h4>
                                    <strong class="text-danger"><?php echo $articleQ['date_publication']; ?></strong><br />
                                    <small>Author : <?php echo isset($articleQ['nom_auteur']) ? $articleQ['nom_auteur'] : "Unknown author"; ?></small>
                                </h4>
                            </div>
                            <hr />
                            <p>
                                <?php echo $articleQ['contenu']; ?>
                            </p>
                            <hr />
                        </div>
                    </div>
                </div>

                <div class="container mt-5">
                    <div class="row justify-content-md-center">
                        <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                            <h2 class="mb-4 display-5 text-center text-danger">The <?php echo $categorie_nom; ?> Articles</h2>
                            <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
                        </div>
                    </div>
                </div>


                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php foreach ($articles_categorie as $key => $article) { ?>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $key; ?>" <?php if ($key === 0) echo 'class="active"'; ?> aria-current="true" aria-label="Slide <?php echo $key; ?>"></button>
                        <?php } ?>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach ($articles_categorie as $key => $article) { ?>
                            <div class="carousel-item <?php if ($key === 0) echo 'active'; ?>">
                                <a href="articles_par_id_ang.php?id=<?php echo $article['id']; ?>&categorie_id=<?php echo $article['categorie_id']; ?>">
                                    <img src="../admin/articles/<?php echo $article['image']; ?>" class="d-block w-100 img-fluid" alt="..." style="max-height: 400px;">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5><?php echo $article['titre']; ?></h5>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            </div>
        </div>
    </main>

    <?php include '../../components/footer.php'; ?>


    <!-- Utilisation des scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
<?php
    } else {
        // Si aucun article n'est trouvé pour cet ID
        echo "";
    }
{
    // Si l'ID de l'article n'est pas spécifié dans l'URL
    echo "";
}
?>
