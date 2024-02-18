<?php
require_once "../const/functions.php";

$categories = getAllCategories();
$AllArticles = DerniersArticlesLimit();

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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

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
        .card {
            background: #fff;
            transition: .5s;
            border: 0;
            margin-bottom: 30px;
            border-radius: .55rem;
            position: relative;
            width: 100%;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
        }
        .card .body {
            color: #444;
            padding: 20px;
            font-weight: 400;
        }
        .card .header {
            color: #444;
            padding: 20px;
            position: relative;
            box-shadow: none;
        }
        .single_post {
            -webkit-transition: all .4s ease;
            transition: all .4s ease
        }

        .single_post .body {
            padding: 30px
        }

        .single_post .img-post {
            position: relative;
            overflow: hidden;
            max-height: 500px;
            margin-bottom: 30px
        }

        .single_post .img-post>img {
            -webkit-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
            opacity: 1;
            -webkit-transition: -webkit-transform .4s ease, opacity .4s ease;
            transition: transform .4s ease, opacity .4s ease;
            max-width: 100%;
            filter: none;
            -webkit-filter: grayscale(0);
            -webkit-transform: scale(1.01)
        }

        .single_post .img-post:hover img {
            -webkit-transform: scale(1.02);
            -ms-transform: scale(1.02);
            transform: scale(1.02);
            opacity: .7;
            filter: gray;
            -webkit-filter: grayscale(1);
            -webkit-transition: all .8s ease-in-out
        }

        .single_post .img-post:hover .social_share {
            display: block
        }

        .single_post .footer {
            padding: 0 30px 30px 30px
        }

        .single_post .footer .actions {
            display: inline-block
        }

        .single_post .footer .stats {
            cursor: default;
            list-style: none;
            padding: 0;
            display: inline-block;
            float: right;
            margin: 0;
            line-height: 35px
        }

        .single_post .footer .stats li {
            border-left: solid 1px rgba(160, 160, 160, 0.3);
            display: inline-block;
            font-weight: 400;
            letter-spacing: 0.25em;
            line-height: 1;
            margin: 0 0 0 2em;
            padding: 0 0 0 2em;
            text-transform: uppercase;
            font-size: 13px
        }

        .single_post .footer .stats li a {
            color: #777
        }

        .single_post .footer .stats li:first-child {
            border-left: 0;
            margin-left: 0;
            padding-left: 0
        }

        .single_post h3 {
            font-size: 20px;
            text-transform: uppercase
        }

        .single_post h3 a {
            color: #242424;
            text-decoration: none
        }

        .single_post p {
            font-size: 16px;
            line-height: 26px;
            font-weight: 300;
            margin: 0
        }

        .single_post .blockquote p {
            margin-top: 0 !important
        }

        .single_post .meta {
            list-style: none;
            padding: 0;
            margin: 0
        }

        .single_post .meta li {
            display: inline-block;
            margin-right: 15px
        }

        .single_post .meta li a {
            font-style: italic;
            color: #959595;
            text-decoration: none;
            font-size: 12px
        }

        .single_post .meta li a i {
            margin-right: 6px;
            font-size: 12px
        }

        .single_post2 {
            overflow: hidden
        }

        .single_post2 .content {
            margin-top: 15px;
            margin-bottom: 15px;
            padding-left: 80px;
            position: relative
        }

        .single_post2 .content .actions_sidebar {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 60px
        }

        .single_post2 .content .actions_sidebar a {
            display: inline-block;
            width: 100%;
            height: 60px;
            line-height: 60px;
            margin-right: 0;
            text-align: center;
            border-right: 1px solid #e4eaec
        }

        .single_post2 .content .title {
            font-weight: 100
        }

        .single_post2 .content .text {
            font-size: 15px
        }

        .right-box .categories-clouds li {
            display: inline-block;
            margin-bottom: 5px
        }

        .right-box .categories-clouds li a {
            display: block;
            border: 1px solid;
            padding: 6px 10px;
            border-radius: 3px
        }

        .right-box .instagram-plugin {
            overflow: hidden
        }

        .right-box .instagram-plugin li {
            float: left;
            overflow: hidden;
            border: 1px solid #fff
        }

        .comment-reply li {
            margin-bottom: 15px
        }

        .comment-reply li:last-child {
            margin-bottom: none
        }

        .comment-reply li h5 {
            font-size: 18px
        }

        .comment-reply li p {
            margin-bottom: 0px;
            font-size: 15px;
            color: #777
        }

        .comment-reply .list-inline li {
            display: inline-block;
            margin: 0;
            padding-right: 20px
        }

        .comment-reply .list-inline li a {
            font-size: 13px
        }

        @media (max-width: 640px) {
            .blog-page .left-box .single-comment-box>ul>li {
                padding: 25px 0
            }
            .blog-page .left-box .single-comment-box ul li .icon-box {
                display: inline-block
            }
            .blog-page .left-box .single-comment-box ul li .text-box {
                display: block;
                padding-left: 0;
                margin-top: 10px
            }
            .blog-page .single_post .footer .stats {
                float: none;
                margin-top: 10px
            }
            .blog-page .single_post .body,
            .blog-page .single_post .footer {
                padding: 30px
            }
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
        <?php include '../components/navbar.php' ?>
    </div>



    <main>
    <div id="main-content" class="blog-page">
        <div class="container">
            <div class="row clearfix">

                <div class="col-lg-8 col-md-12 left-box">
                    <div class="card single_post">
                        <div class="body">
                            <div class="img-post">
                                <img class="d-block img-fluid" src="./admin/articles/<?php echo $Article_by_id['image']; ?>" alt="First slide">
                            </div>
                            <h3><?php echo $Article_by_id['titre']; ?></h3>
                            <p><?php echo $Article_by_id['contenu']; ?></p>
                        </div>                        
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 right-box">
                    <div class="card">
                        <div class="header">
                            <h2>Categories</h2>
                        </div>
                        <div class="body widget">
                            <ul class="list-unstyled categories-clouds m-b-0">
                                <?php foreach ($categories as $categorie) : ?>
                                    <li><a href="articles_par_categorie.php?categorie_id=<?php echo $categorie['id_categorie']; ?>" class="dropdown-item">Articles <?php echo $categorie['nom_categorie']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>Derniers Articles</h2>
                        </div>
                        <div class="body widget popular-post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php foreach($AllArticles as $article) : ?>
                                        <div class="single_post mb-4">
                                            <a href="article_id.php?id=<?php echo $article['id']; ?>">
                                                <div class="img-post">
                                                    <img src="./admin/articles/<?php echo $article['image']; ?>" alt="">
                                                </div>
                                            </a>
                                            <p class="m-b-0"><a href="article_id.php?id=<?php echo $article['id']; ?>" class="text-decoration-none text-secondary"><?php echo $article['titre']; ?></a></p>
                                            <span><?php echo $article['date_publication']; ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
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
        echo "";
    }
} else {
    // Si l'ID de l'article n'est pas spécifié dans l'URL
    echo "";
}
?>
