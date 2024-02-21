<?php

require_once "../../const/functions.php";

// Nombre d'articles par page
$articlesPerPage = 9;
$categories = getAllCategories();

// Page par défaut
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Récupérer les articles pour la page spécifiée
$startFrom = ($page - 1) * $articlesPerPage;

// Si une recherche est effectuée, récupérer les articles de la recherche, sinon récupérer tous les articles
if(isset($_GET['q'])){
    $txtSearch = $_GET['q'];
    $AllArticles = rechercheArticle($txtSearch);
} else {
    $AllArticles = getAllArticlesLimitAr($startFrom, $articlesPerPage);
}

// Récupérer le nombre total d'articles
$totalArticles = getTotalArticlesCount();
$totalPages = ceil($totalArticles / $articlesPerPage);

?>

<!doctype html>
<html lang="en">
<head>
    <title>Tous les articles</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
    />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/blogs/blog-2/assets/css/blog-2.css">


    <style>
        .custom-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 21px -12px rgba(0, 0, 0, 0.66);
            overflow: hidden;
        }

        .custom-card-img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .custom-btn {
            background-color: #007bff;
            border-color: #007bff;
        }

        .custom-btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .card-horizontal .card-body {
            padding: 1.25rem;
        }

        @media (max-width: 992px) {
            .navbar-custom-young {
                flex-direction: row !important;
            }
        }
    </style>

</head>

<body>
<header>
    <?php include '../../components/navbar_ar.php' ?>
</header>
<!-- Main Content -->
<div class="container mt-5">

    <section class="py-3 py-md-5 py-xl-8">

        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                    <h2 class="mb-4 display-5 text-center text-danger">جميع المقالات</h2>
                    <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
                </div>
            </div>
        </div>

        <div class="container overflow-hidden">
            <div class="row gy-3 gy-lg-0 gx-xxl-5">
                <?php if (!empty($AllArticles)) : ?>
                    <?php foreach ($AllArticles as $article) : ?> <!-- corrected variable name from $articles to $article -->
                        <div class="col-12 col-lg-4 mt-3">
                            <article>
                                <figure class="rounded overflow-hidden mb-3 bsb-overlay-hover">
                                    <a href='article_id_ar.php?id=<?php echo $article['id']; ?>'>
                                        <img class="img-fluid bsb-scale bsb-hover-scale-up" loading="lazy"
                                             src="../admin/articles/<?php echo $article['image']; ?>" alt="">
                                    </a>
                                    <figcaption>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                             fill="currentColor" class="bi bi-eye text-white bsb-hover-fadeInLeft"
                                             viewBox="0 0 16 16">
                                            <path
                                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                            <path
                                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                        </svg>
                                        <h4 class="h6 text-white bsb-hover-fadeInRight mt-2">Lire</h4>
                                    </figcaption>
                                </figure>
                                <div class="entry-header mb-3">
                                    <ul class="entry-meta list-unstyled d-flex mb-2">
                                        <li>
                                            <a class="link-danger text-decoration-none"
                                               href="articles_par_categorie_ar.php?categorie_id=<?php echo $article['categorie_id']; ?>"><?php echo $article['nom_categorie']; ?></a>
                                        </li>
                                    </ul>
                                    <h2 class="entry-title h4 mb-0">
                                        <a class="link-dark text-decoration-none"
                                           href='article_id.php?id=<?php echo $article['id']; ?>'><?php echo $article['titre']; ?></a> <!-- corrected variable name from $firstArticle to $article -->
                                    </h2>
                                </div>
                                <div class="entry-footer">
                                    <ul class="entry-meta list-unstyled d-flex align-items-center mb-0">
                                        <li>
                                            <div class="fs-7 link-secondary text-decoration-none d-flex align-items-center"
                                                 href="#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                     fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                                    <path
                                                            d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                                                    <path
                                                            d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                                </svg>
                                                <span class="ms-2 fs-7"><?php echo date('Y-m-d H:i', strtotime($article['date_publication'])); ?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="px-3">&bull;</span>
                                        </li>
                                        <li>
                                            <div class="link-secondary text-decoration-none d-flex align-items-center"
                                                 href="#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                     fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                    <path
                                                            d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 1c-2.667 0-8 1.334-8 4v1c0 .619 1.262 1 4 1h8c2.738 0 4-.381 4-1v-1c0-2.666-5.333-4-8-4z"/>
                                                    <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                </svg>
                                                <span class="ms-2 fs-7"><?php echo $article['nom_auteur']; ?></span> <!-- corrected variable name from $firstArticle to $article -->
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center mt-5">
                <?php if ($page > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1"
                           aria-disabled="true">Précédent</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Suivant</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

    </section>

</div>


<!-- Include Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<footer>
    <!-- place footer here -->
</footer>
<!-- Bootstrap JavaScript Libraries -->
<script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"
></script>

<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"
></script>
</body>
</html>
