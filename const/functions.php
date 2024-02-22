<?php



function connect() {
    $serveur = "localhost";
    $utilisateur = "root";
    $mot_de_passe = "";
    $nom_base_de_données = "pfsh";
    
    $connect = new mysqli($serveur, $utilisateur, $mot_de_passe, $nom_base_de_données);
    
    if ($connect->connect_error) {
        die("Échec de la connexion : " . $connect->connect_error);
    }
    
    return $connect;
}



/*------------------Recuperation de categories, utilisateurs, Articles et langues---------------------- */

function getAllCategories() {
    $connect = connect();

    $sql = "SELECT * FROM categories";

    $result = $connect->query($sql);

    $categories = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $categories;
}

function getAllLanguages() {
    // Connexion à la base de données
    $connect = connect();

    // Requête SQL pour récupérer toutes les langues
    $sql = "SELECT * FROM language";

    // Exécution de la requête
    $result = $connect->query($sql);

    // Vérification des erreurs
    if (!$result) {
        die("Erreur lors de l'exécution de la requête : " . $connect->error);
    }

    // Récupération des résultats
    $langs = $result->fetch_all(MYSQLI_ASSOC);

    // Fermeture de la connexion
    $connect->close();

    return $langs;
}

function getAllUsers() {
    $connect = connect();

    $sql = "SELECT * FROM users";

    $result = $connect->query($sql);

    $users = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $users;
}

function getAllArticles() {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON articles.categorie_id = categories.id_categorie
    ORDER BY articles.date_publication DESC";

    $result = $connect->query($sql);

    $allArticles = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $allArticles;
}

function getAllArticlesByAuthor($id_user) {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON articles.categorie_id = categories.id_categorie
    WHERE articles.user_id = $id_user
    ORDER BY articles.date_publication DESC";

    $result = $connect->query($sql);

    $articlesByAuthor = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $articlesByAuthor;
}



/*------------------Authentification de l'utilisateur---------------------- */


function authentifier_user($nom_utilisateur, $mot_de_passe) {
    $connect = connect();
    
    // Prévenir les injections SQL
    $stmt = $connect->prepare("SELECT * FROM users WHERE nom_utilisateur=? AND mot_de_passe=?");
    $stmt->bind_param("ss", $nom_utilisateur, $mot_de_passe);
    $stmt->execute();
    
    $resultat = $stmt->get_result();
    
    if($resultat->num_rows == 1) {
        $row = $resultat->fetch_assoc();
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['nom_utilisateur'] = $row['nom_utilisateur'];
        $_SESSION['mot_de_passe'] = $row['mot_de_passe'];
        $_SESSION['role'] = $row['role'];
        return true;
    } else {
        return false;
    }
}






/*------------------Recuperation des articles en fonction dans langues---------------------- */

function getAllArticlesFr() {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON articles.categorie_id = categories.id_categorie
    JOIN language ON articles.code_lang = language.code_lang
    WHERE articles.code_lang = '1'
    ORDER BY articles.date_publication DESC";

    $result = $connect->query($sql);

    $allArticles = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $allArticles;
}
function getAllArticlesAr() {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON articles.categorie_id = categories.id_categorie
    JOIN language ON articles.code_lang = language.code_lang
    WHERE articles.code_lang = '2'
    ORDER BY articles.date_publication DESC";

    $result = $connect->query($sql);

    $allArticles = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $allArticles;
}
function getAllArticlesAng() {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON articles.categorie_id = categories.id_categorie
    JOIN language ON articles.code_lang = language.code_lang
    WHERE articles.code_lang = '3'
    ORDER BY articles.date_publication DESC";

    $result = $connect->query($sql);

    $allArticles = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $allArticles;
}




/*------------------Recuperation des articles pour les Components/Pages---------------------- */


function getArticlesByCategorieFr($categorie_id) {
    $connect = connect();

    // Préparez la requête SQL pour récupérer les articles de la catégorie spécifiée avec les détails de l'auteur
    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom)  AS nom_auteur, categories.nom_categorie
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON categories.id_categorie = articles.categorie_id
    JOIN language ON language.code_lang = articles.code_lang
    WHERE articles.categorie_id = ? AND articles.code_lang = '1'
    ORDER BY date_publication DESC";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("i", $categorie_id);

    // Exécutez la déclaration
    $stmt->execute();

    // Obtenez le résultat de la requête
    $result = $stmt->get_result();

    // Vérifiez s'il y a des résultats
    if ($result->num_rows > 0) {
        // Créez un tableau pour stocker les articles
        $articles = array();

        // Parcourir les résultats et les stocker dans le tableau
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }

        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        // Retourner les articles
        return $articles;
    } else {
        // Aucun article trouvé
        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        return false;
    }
}

function getArticlesByCategorieAr($categorie_id) {
    $connect = connect();

    // Préparez la requête SQL pour récupérer les articles de la catégorie spécifiée avec les détails de l'auteur
    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom)  AS nom_auteur, categories.nom_categorie_ar
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON categories.id_categorie = articles.categorie_id
    JOIN language ON articles.code_lang = language.code_lang
    WHERE articles.categorie_id = ? AND articles.code_lang = '2'
    ORDER BY date_publication DESC";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("i", $categorie_id);

    // Exécutez la déclaration
    $stmt->execute();

    // Obtenez le résultat de la requête
    $result = $stmt->get_result();

    // Vérifiez s'il y a des résultats
    if ($result->num_rows > 0) {
        // Créez un tableau pour stocker les articles
        $articles = array();

        // Parcourir les résultats et les stocker dans le tableau
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }

        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        // Retourner les articles
        return $articles;
    } else {
        // Aucun article trouvé
        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        return false;
    }
}

function getArticlesByCategorieAng($categorie_id) {
    $connect = connect();

    // Préparez la requête SQL pour récupérer les articles de la catégorie spécifiée avec les détails de l'auteur
    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom)  AS nom_auteur, categories.nom_categorie
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON categories.id_categorie = articles.categorie_id
    JOIN language ON articles.code_lang = language.code_lang
    WHERE articles.categorie_id = ? AND articles.code_lang = '3'
    ORDER BY date_publication DESC";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("i", $categorie_id);

    // Exécutez la déclaration
    $stmt->execute();

    // Obtenez le résultat de la requête
    $result = $stmt->get_result();

    // Vérifiez s'il y a des résultats
    if ($result->num_rows > 0) {
        // Créez un tableau pour stocker les articles
        $articles = array();

        // Parcourir les résultats et les stocker dans le tableau
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }

        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        // Retourner les articles
        return $articles;
    } else {
        // Aucun article trouvé
        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        return false;
    }
}





function getArticleById($id_article) {
    $connect = connect();

    // Préparez la requête SQL pour récupérer l'article spécifié avec les détails de l'auteur et de la catégorie
    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom)  AS nom_auteur, categories.nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON categories.id_categorie = articles.categorie_id
            WHERE articles.id = ?";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("i", $id_article);

    // Exécutez la déclaration
    $stmt->execute();

    // Obtenez le résultat de la requête
    $result = $stmt->get_result();

    // Vérifiez s'il y a des résultats
    if ($result->num_rows > 0) {
        // Récupérez et retournez l'article
        $article = $result->fetch_assoc();
        
        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        return $article;
    } else {
        // Aucun article trouvé
        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        return false;
    }
}





function getRecentArticleFr() {
    $connect = connect(); // Supposons que cette fonction 'connect()' établit une connexion à la base de données

    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom) AS nom_auteur, categories.nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON categories.id_categorie = articles.categorie_id
            JOIN language ON articles.code_lang = language.code_lang
            WHERE articles.code_lang = '1'
            ORDER BY articles.date_publication DESC
            LIMIT 1";

    $stmt = $connect->prepare($sql);

    // Exécute la requête
    $stmt->execute();

    // Récupère le résultat
    $result = $stmt->get_result();

    // Vérifie si des résultats ont été trouvés
    if ($result->num_rows > 0) {
        // Récupère la première ligne de résultat (dans ce cas, le seul résultat car LIMIT 1 est utilisé)
        $recentArticle = $result->fetch_assoc();
        return $recentArticle;
    } else {
        // Aucun article trouvé
        return null;
    }
}

function getRecentArticleAr() {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom) AS nom_auteur, categories.nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON categories.id_categorie = articles.categorie_id
            JOIN language ON articles.code_lang = language.code_lang
            WHERE articles.code_lang = '2'
            ORDER BY articles.date_publication DESC
            LIMIT 1";

    $stmt = $connect->prepare($sql);

    // Exécute la requête
    $stmt->execute();

    // Récupère le résultat
    $result = $stmt->get_result();

    // Vérifie si des résultats ont été trouvés
    if ($result->num_rows > 0) {
        // Récupère la première ligne de résultat (dans ce cas, le seul résultat car LIMIT 1 est utilisé)
        $recentArticle = $result->fetch_assoc();
        return $recentArticle;
    } else {
        // Aucun article trouvé
        return null;
    }
}

function getRecentArticleAng() {
    $connect = connect(); // Supposons que cette fonction 'connect()' établit une connexion à la base de données

    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom) AS nom_auteur, categories.nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON categories.id_categorie = articles.categorie_id
            JOIN language ON articles.code_lang = language.code_lang
            WHERE articles.code_lang = '3'
            ORDER BY articles.date_publication DESC
            LIMIT 1";

    $stmt = $connect->prepare($sql);

    // Exécute la requête
    $stmt->execute();

    // Récupère le résultat
    $result = $stmt->get_result();

    // Vérifie si des résultats ont été trouvés
    if ($result->num_rows > 0) {
        // Récupère la première ligne de résultat (dans ce cas, le seul résultat car LIMIT 1 est utilisé)
        $recentArticle = $result->fetch_assoc();
        return $recentArticle;
    } else {
        // Aucun article trouvé
        return null;
    }
}




function getMostRecentArticleInCategoryFr($categorie_id) {
    $connect = connect();

    // Préparez la requête SQL pour récupérer le dernier article publié de la catégorie spécifiée
    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom)  AS nom_auteur, categories.nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON categories.id_categorie = articles.categorie_id
            JOIN language ON articles.code_lang = language.code_lang
            WHERE articles.categorie_id = ? AND articles.code_lang = '1'
            ORDER BY articles.date_publication DESC
            LIMIT 1";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("i", $categorie_id);

    // Exécutez la déclaration
    $stmt->execute();

    // Obtenez le résultat de la requête
    $result = $stmt->get_result();

    // Vérifiez s'il y a des résultats
    if ($result->num_rows > 0) {
        // Récupérez et retournez le dernier article publié de la catégorie
        $mostRecentArticle = $result->fetch_assoc();
        
        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        return $mostRecentArticle;
    } else {
        // Aucun article trouvé
        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        return false;
    }
}
function getMostRecentArticleInCategoryAr($categorie_id) {
    $connect = connect();

    // Préparez la requête SQL pour récupérer le dernier article publié de la catégorie spécifiée
    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom)  AS nom_auteur, categories.nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON categories.id_categorie = articles.categorie_id
            JOIN language ON articles.code_lang = language.code_lang
            WHERE articles.categorie_id = ? AND articles.code_lang = '2'
            ORDER BY articles.date_publication DESC
            LIMIT 1";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("i", $categorie_id);

    // Exécutez la déclaration
    $stmt->execute();

    // Obtenez le résultat de la requête
    $result = $stmt->get_result();

    // Vérifiez s'il y a des résultats
    if ($result->num_rows > 0) {
        // Récupérez et retournez le dernier article publié de la catégorie
        $mostRecentArticle = $result->fetch_assoc();
        
        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        return $mostRecentArticle;
    } else {
        // Aucun article trouvé
        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        return false;
    }
}
function getMostRecentArticleInCategoryAng($categorie_id) {
    $connect = connect();

    // Préparez la requête SQL pour récupérer le dernier article publié de la catégorie spécifiée
    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom)  AS nom_auteur, categories.nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON categories.id_categorie = articles.categorie_id
            JOIN language ON articles.code_lang = language.code_lang
            WHERE articles.categorie_id = ? AND articles.code_lang = '2'
            ORDER BY articles.date_publication DESC
            LIMIT 1";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("i", $categorie_id);

    // Exécutez la déclaration
    $stmt->execute();

    // Obtenez le résultat de la requête
    $result = $stmt->get_result();

    // Vérifiez s'il y a des résultats
    if ($result->num_rows > 0) {
        // Récupérez et retournez le dernier article publié de la catégorie
        $mostRecentArticle = $result->fetch_assoc();
        
        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        return $mostRecentArticle;
    } else {
        // Aucun article trouvé
        // Fermez la déclaration et la connexion
        $stmt->close();
        $connect->close();

        return false;
    }
}





function DerniersArticlesLimit() {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON articles.categorie_id = categories.id_categorie
            ORDER BY articles.date_publication DESC LIMIT 3";

    $result = $connect->query($sql);

    $allArticles = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $allArticles;
}

function DerniersArticlesLimitFr() {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON articles.categorie_id = categories.id_categorie
            JOIN language ON articles.code_lang = language.code_lang
            WHERE articles.code_lang = '1'
            ORDER BY articles.date_publication DESC LIMIT 3";

    $result = $connect->query($sql);

    $allArticlesFr = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $allArticlesFr;
}

function DerniersArticlesLimitAr() {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON articles.categorie_id = categories.id_categorie
            JOIN language ON articles.code_lang = language.code_lang
            WHERE articles.code_lang = '2'
            ORDER BY articles.date_publication DESC LIMIT 3";

    $result = $connect->query($sql);

    $allArticlesAr = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $allArticlesAr;
}

function DerniersArticlesLimitAng() {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON articles.categorie_id = categories.id_categorie
            JOIN language ON articles.code_lang = language.code_lang
            WHERE articles.code_lang = '3'
            ORDER BY articles.date_publication DESC LIMIT 3";

    $result = $connect->query($sql);

    $allArticlesAng = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $allArticlesAng;
}






function getTotalArticlesCount() {
    // Connexion à la base de données
    $connect = connect(); // Assurez-vous d'avoir la fonction connect() qui se connecte à votre base de données

    // Requête SQL pour compter le nombre total d'articles
    $sql = "SELECT COUNT(*) AS total FROM articles";

    // Préparation de la requête
    $stmt = $connect->prepare($sql);

    // Exécution de la requête
    $stmt->execute();

    // Récupération du résultat
    $result = $stmt->get_result(); // Utilisez get_result() pour obtenir le résultat avec l'API orientée objet

    // Vérifiez si des lignes sont retournées
    if ($result->num_rows > 0) {
        // Récupération du nombre total d'articles
        $row = $result->fetch_assoc();
        $total = $row['total'];
    } else {
        // S'il n'y a pas d'articles, définissez le total sur 0
        $total = 0;
    }

    // Retourner le nombre total d'articles
    return $total;
}







/*---------------------------------La pagination-------------------------- */


function getAllArticlesLimitFr($startFrom, $articlesPerPage) {
    $connect = connect();

    // Préparation de la requête SQL pour récupérer une portion des articles
    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON articles.categorie_id = categories.id_categorie
    JOIN language ON articles.code_lang = language.code_lang
    WHERE articles.code_lang = '1'
    ORDER BY articles.date_publication DESC Limit ?, ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii", $startFrom, $articlesPerPage);
    
    // Exécution de la requête
    $stmt->execute();
    
    // Obtention du résultat
    $result = $stmt->get_result();
    
    // Création d'un tableau pour stocker les articles récupérés
    $articles = array();
    
    // Vérification si des résultats ont été trouvés
    if ($result->num_rows > 0) {
        // Parcourir chaque ligne de résultat
        while ($row = $result->fetch_assoc()) {
            // Ajouter l'article à la liste des articles
            $articles[] = $row;
        }
    }
    
    // Fermeture de la connexion et retour de la liste des articles
    $stmt->close();
    $connect->close();
    return $articles;
}

function getAllArticlesLimitAr($startFrom, $articlesPerPage) {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie_ar AS nom_categorie_ar
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON articles.categorie_id = categories.id_categorie
    JOIN language ON articles.code_lang = language.code_lang
    WHERE articles.code_lang = '2'
    ORDER BY articles.date_publication DESC Limit ?, ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii", $startFrom, $articlesPerPage);
    
    // Exécution de la requête
    $stmt->execute();
    
    // Obtention du résultat
    $result = $stmt->get_result();
    
    // Création d'un tableau pour stocker les articles récupérés
    $articles = array();
    
    // Vérification si des résultats ont été trouvés
    if ($result->num_rows > 0) {
        // Parcourir chaque ligne de résultat
        while ($row = $result->fetch_assoc()) {
            // Ajouter l'article à la liste des articles
            $articles[] = $row;
        }
    }
    
    // Fermeture de la connexion et retour de la liste des articles
    $stmt->close();
    $connect->close();
    return $articles;
}

function getAllArticlesLimitAng($startFrom, $articlesPerPage) {
    $connect = connect();

    // Préparation de la requête SQL pour récupérer une portion des articles
    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie_ang AS nom_categorie_ang
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON articles.categorie_id = categories.id_categorie
    JOIN language ON articles.code_lang = language.code_lang
    WHERE articles.code_lang = '3'
    ORDER BY articles.date_publication DESC Limit ?, ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii", $startFrom, $articlesPerPage);
    
    // Exécution de la requête
    $stmt->execute();
    
    // Obtention du résultat
    $result = $stmt->get_result();
    
    // Création d'un tableau pour stocker les articles récupérés
    $articles = array();
    
    // Vérification si des résultats ont été trouvés
    if ($result->num_rows > 0) {
        // Parcourir chaque ligne de résultat
        while ($row = $result->fetch_assoc()) {
            // Ajouter l'article à la liste des articles
            $articles[] = $row;
        }
    }
    
    // Fermeture de la connexion et retour de la liste des articles
    $stmt->close();
    $connect->close();
    return $articles;
}





/*------------------Total pour le tableau de bord---------------------- */

function totalArticles() {
    $connect = connect();

    $sql = "SELECT COUNT(id) as total FROM articles";

    $result = $connect->query($sql);

    // Fetch the result as an associative array
    $total_articles = $result->fetch_assoc();

    // Close the database connection
    $connect->close();

    // Return the total count of articles
    return $total_articles['total'];
}

function totalCategories() {
    $connect = connect();

    $sql = "SELECT COUNT(id_categorie) as total FROM categories";

    $result = $connect->query($sql);

    // Fetch the result as an associative array
    $total_categories = $result->fetch_assoc();

    // Close the database connection
    $connect->close();

    // Return the total count of articles
    return $total_categories['total'];
}

function totalAuteurs() {
    $connect = connect();

    $sql = "SELECT COUNT(id_user) as total FROM users";

    $result = $connect->query($sql);

    // Fetch the result as an associative array
    $total_auteurs = $result->fetch_assoc();

    // Close the database connection
    $connect->close();

    // Return the total count of articles
    return $total_auteurs['total'];
}









/*------------------Les insersions dans les tables---------------------- */


function insertArticle($titre, $categorie_id, $user_id,$contenu, $image, $langue) {
    $connect = connect();

    // Préparez la requête SQL pour insérer un nouvel article
    $sql = "INSERT INTO articles (titre, categorie_id, user_id, contenu, image, code_lang) VALUES (?, ?, ?, ?, ?, ?)";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("siissi", $titre, $categorie_id, $user_id, $contenu, $image, $langue);

    // Exécutez la déclaration
    $stmt->execute();

    // Fermez la déclaration et la connexion
    $stmt->close();
    $connect->close();
}

function insertCategorie($nom_categorie,$nom_categorie_ar,$nom_categorie_ang) {
    $connect = connect();

    // Préparez la requête SQL pour insérer un nouvel article
    $sql = "INSERT INTO categories (nom_categorie,nom_categorie_ar,nom_categorie_ang) VALUES (?,?,?)";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("sss", $nom_categorie,$nom_categorie_ar,$nom_categorie_ang);

    // Exécutez la déclaration
    $stmt->execute();

    // Fermez la déclaration et la connexion
    $stmt->close();
    $connect->close();
}

function insertUser( $prenom,$nom,$nom_utilisateur,$mot_de_passe ) {
    $connect = connect();

    // Préparez la requête SQL pour insérer un nouvel article/
    $sql = "INSERT INTO users (prenom, nom, nom_utilisateur, mot_de_passe) VALUES (?, ?, ?, ?)";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("ssss", $prenom,$nom,$nom_utilisateur,$mot_de_passe);

    // Exécutez la déclaration
    $stmt->execute();

    // Fermez la déclaration et la connexion
    $stmt->close();
    $connect->close();
}










/*------------------La recherche des articles---------------------- */

function rechercheArticle($txtSearch) {
    $connect = connect();

    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON articles.categorie_id = categories.id_categorie
    WHERE articles.titre LIKE '%$txtSearch%'
    ORDER BY articles.date_publication DESC";

    // Exemple d'exécution de la requête
    $resultat = mysqli_query($connect, $sql);

    // Si vous souhaitez retourner les résultats, vous pouvez les stocker dans un tableau
    $articlesTrouves = array();
    while ($row = mysqli_fetch_assoc($resultat)) {
        $articlesTrouves[] = $row;
    }

    // Retourner les articles trouvés
    return $articlesTrouves;
}


?>