<?php
require_once "../const/functions.php";

$categories = getAllCategories();
$AllArticles = DerniersArticlesLimit(); 

// Récupérer l'article le plus récent
$latestArticle = $AllArticles[0];

// Récupérer les clés de la catégorie et de l'article le plus récent
$categorie_id = $latestArticle['categorie_id'];
$article_id = $latestArticle['id'];
$categorie_nom = isset($categories[$categorie_id]['nom_categorie']) ? $categories[$categorie_id]['nom_categorie'] : "";
?>

<!doctype html>
<html lang="en">
<head>
    <title>Les articles</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
        }
        header {
            background-color: #212529
            color: #ffffff;
            padding: 20px;
        }
        main {
            padding: 20px;
        }
        footer {
            background-color: #212529;
            color: #ffffff;
            padding: 20px;
        }
        .card-thumbnail {
            max-height: 250px;
            overflow: hidden;
        }
        @media (max-width: 992px) {
            .navbar-custom-young {
                flex-direction: row !important;
            }
        }

        .push-bit {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    
    <div>
        <?php include '../components/navbar.php' ?>
    </div>

    <main>
        <div class="container-fluid">
            <div class="row">

            <section class="bg-light py-4 my-5">
                <div class="container">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($AllArticles as $article) : ?>
                            <?php
                            // Limiter la longueur du titre
                            $trimmedTitle = strlen($article['titre']) > 75 ? substr($article['titre'], 0, 75) . '...' : $article['titre'];
                            ?>
                            <div class="col">
                                <div class="card h-100">
                                    <a href="article_id.php?id=<?php echo $article['id']; ?>"><img src="./admin/articles/<?php echo $article['image']; ?>" class="card-img-top" alt="thumbnail"></a>
                                    <div class="card-body">
                                        <h3 class="card-title" title="<?php echo $article['titre']?>"><a href="article_id.php?id=<?php echo $article['id']; ?>" class="text-secondary"><?php echo $trimmedTitle; ?></a></h3>
                                        <p class="card-text"><?php echo $article['date_publication']; ?></p>
                                        <div>
                                            <a href="article_id.php?id=<?php echo $article['id']; ?>" class="btn btn-danger">Lire</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

                <div class="container">
                    <div class="row justify-content-md-center">
                        <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                            <h2 class="mb-4 display-5 text-center">Dernier Article</h2>
                            <p class="text-secondary mb-5 text-center lead fs-4">Restez à l'écoute et informé des dernières mises à jour.</p>
                            <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
                        </div>
                    </div>
                </div>


                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#" class="gallery-link">
                                <img src="./admin/articles/<?php echo $latestArticle['image']; ?>" alt="" class="img-responsive push-bit img-thumbnail" style="max-width: 100%; height: auto;" />
                            </a>
                        </div>
                        <div class="col-md-6">
                            <div class="clearfix">
                                <div class="pull-right">
                                    <h2 class="text-uppercase"><strong><?php echo $latestArticle['titre']; ?></strong></h2>
                                </div>
                                <h4>
                                    <strong class="text-success"><?php echo $latestArticle['date_publication']; ?></strong><br />
                                    <small><?php echo isset($latestArticle['nom_auteur']) ? $latestArticle['nom_auteur'] : "Auteur inconnu"; ?></small>
                                </h4>
                            </div>
                            <hr />
                            <p>
                                <?php echo $latestArticle['contenu']; ?>
                            </p>
                            <hr />
                        </div>
                    </div>
                </div>





            </div>
        </div>
    </main>

    <!-- Utilisation des scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function changeLanguage() {
            var language = jQuery('#language').val();
            window.location.href = 'http://localhost/PFSH/pages/?language='+language;
        }
    </script>
</body>
</html>
