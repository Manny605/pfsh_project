<?php
require_once "../../const/functions.php";

$categories = getAllCategories();

$AllArticlesAr = DerniersArticlesLimitAr(); 

$latestArticleAr = getRecentArticleAr();

$categorie_nom = "";
if ($latestArticleAr !== null) {
    $categorie_id = $latestArticleAr['categorie_id'];
    $categorie_nom = isset($categories[$categorie_id]['nom_categorie_ar']) ? $categories[$categorie_id]['nom_categorie_ar'] : "";
}
?>


<!doctype html>
<html lang="ar">
<head>
    <title>أنصار الفكر - أخبار</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #ffffff;
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
        <?php include '../../components/navbar_ar.php' ?>
    </div>

    <main>
        <div class="container-fluid">
            <div class="row">

            <div class="container mt-5">
                    <div class="row justify-content-md-center">
                        <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                            <h2 class="mb-4 display-5 text-center text-danger">أخبار</h2>
                            <p class="text-secondary mb-5 text-center lead fs-4 text-danger">ابقَ على اطلاع وتَوَاصَل مَع آخِر التحديثات</p>
                            <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
                        </div>
                    </div>
            </div>

            <section class="bg-white py-4">
                <div class="container">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($AllArticlesAr as $articleAr) : ?>
                            <?php
                            // Limiter la longueur du titre
                            $trimmedTitle = strlen($articleAr['titre']) > 75 ? substr($articleAr['titre'], 0, 75) . '...' : $articleAr['titre'];
                            ?>
                            <div class="col">
                                <div class="card h-100">
                                    <a href="article_id_ar.php?id=<?php echo $articleAr['id']; ?>"><img src="../admin/articles/<?php echo $articleAr['image']; ?>" class="card-img-top" alt="thumbnail"></a>
                                    <div class="card-body">
                                        <h3 class="card-title" title="<?php echo $articleAr['titre']?>"><a href="article_id_ar.php?id=<?php echo $articleAr['id']; ?>" class="text-secondary"><?php echo $trimmedTitle; ?></a></h3>
                                        <p class="card-text"><?php echo $articleAr['date_publication']; ?></p>
                                        <div>
                                            <a href="article_id_ar.php?id=<?php echo $articleAr['id']; ?>" class="btn btn-danger">قراءة</a>
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
                            <h2 class="mb-4 display-5 text-center text-danger">المقال الأخير</h2>
                            <!-- <p class="text-secondary mb-5 text-center lead fs-4 text-danger">Restez à l'écoute et informé des dernières mises à jour.</p> -->
                            <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
                        </div>
                    </div>
                </div>


                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <?php if ($latestArticleAr !== null) : ?>
                                <a href="" class="gallery-link">
                                    <img src="../admin/articles/<?php echo $latestArticleAr['image']; ?>" alt="" class="img-responsive push-bit img-thumbnail" style="max-width: 100%; height: auto;" />
                                </a>
                                <div class="clearfix">
                                    <div class="pull-right">
                                        <h2 class="text-uppercase"><strong><?php echo $latestArticleAr['titre']; ?></strong></h2>
                                    </div>
                                    <h4>
                                        <strong class="text-danger"><?php echo $latestArticleAr['date_publication']; ?></strong><br />
                                        <small><?php echo isset($latestArticleAr['nom_auteur']) ? $latestArticleAr['nom_auteur'] : "Auteur inconnu"; ?> : المؤلف</small>
                                    </h4>
                                </div>
                                <hr />
                                <p>
                                    <?php echo $latestArticleAr['contenu']; ?>
                                </p>
                                <hr />
                            <?php else : ?>
                                <p>Aucun Article n'est disponible</p>
                            <?php endif; ?>
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

</body>
</html>
