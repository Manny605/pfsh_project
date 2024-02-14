<?php
require_once "../const/functions.php";

$categories = getAllCategories();
$AllArticles = getAllArticles(); 

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
                    <div class="row">
                        <div class="col-12">
                            <h2 class="mb-3 text-danger">A la une</h2>
                        </div>

                        <?php 
                        foreach ($AllArticles as $article) {
                            // Limiter la longueur du titre
                            $trimmedTitle = strlen($article['titre']) > 75 ? substr($article['titre'], 0, 75) . '...' : $article['titre'];
                        ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card my-3">
                                <div class="card-thumbnail">
                                    <img src="<?php echo $article['image']; ?>" class="img-fluid" alt="thumbnail">
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title" title="<?php echo $article['titre']?>"><a href="#" class="text-secondary"><?php echo $trimmedTitle; ?></a></h3>
                                    <p class="card-text"><?php echo $article['date_publication']; ?></p>
                                    <div>
                                        <a href="#" class="btn btn-danger">Lire</a>
                                        
                                    </div>
                                  </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </section>

                <div class="container">
                    <div class="row justify-content-md-center">
                        <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                            <h2 class="mb-4 display-5 text-center">Tous les articles</h2>
                            <p class="text-secondary mb-5 text-center lead fs-4">Stay tuned and updated by the latest updates from our blog.</p>
                            <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
                        </div>
                    </div>
                </div>

                <div class="container bg-light p-4 rounded">
                    <h2 class="mb-4">Dernier Article</h2>
                    <div class="card">
                        <img src="<?php echo $latestArticle['image'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h2 class="card-title"><?php echo $latestArticle['titre'] ?></h2>
                            <hr>
                            <p class="card-text"><?php echo $latestArticle['contenu'] ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <p class="m-0">Date de publication : <?php echo $latestArticle['date_publication'] ?></p>
                            <p class="m-0">Auteur : <?php echo isset($latestArticle['nom_auteur']) ? $latestArticle['nom_auteur'] : "Auteur inconnu"; ?></p>
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
