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

function getAllCategories() {
    $connect = connect();

    $sql = "SELECT id_categorie, nom_categorie FROM categories";

    $result = $connect->query($sql);

    $categories = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $categories;
}

function getArticlesByCategorie($categorie_id) {
    $connect = connect();

    // Préparez la requête SQL pour récupérer les articles de la catégorie spécifiée avec les détails de l'auteur
    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom)  AS nom_auteur, categories.nom_categorie
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON categories.id_categorie = articles.categorie_id
    WHERE articles.categorie_id = ?
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

function getRecentArticle() {
    $connect = connect(); // Supposons que cette fonction 'connect()' établit une connexion à la base de données

    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom) AS nom_auteur, categories.nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON categories.id_categorie = articles.categorie_id
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

function getMostRecentArticleInCategory($categorie_id) {
    $connect = connect();

    // Préparez la requête SQL pour récupérer le dernier article publié de la catégorie spécifiée
    $sql = "SELECT articles.*, CONCAT(users.prenom,' ',users.nom)  AS nom_auteur, categories.nom_categorie
            FROM articles
            JOIN users ON articles.user_id = users.id_user
            JOIN categories ON categories.id_categorie = articles.categorie_id
            WHERE articles.categorie_id = ?
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
            ORDER BY articles.date_publication DESC LIMIT 3 offset 1";

    $result = $connect->query($sql);

    $allArticles = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $allArticles;
}

function getAllArticlesLimit($startFrom, $articlesPerPage) {
    $connect = connect();

    // Préparation de la requête SQL pour récupérer une portion des articles
    $sql = "SELECT articles.*, CONCAT(users.prenom, ' ', users.nom) AS nom_auteur, categories.nom_categorie AS nom_categorie
    FROM articles
    JOIN users ON articles.user_id = users.id_user
    JOIN categories ON articles.categorie_id = categories.id_categorie
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

function getAllUsers() {
    $connect = connect();

    $sql = "SELECT * FROM users";

    $result = $connect->query($sql);

    $users = $result->fetch_all(MYSQLI_ASSOC);

    $connect->close();

    return $users;
}

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

function getTotalArticlesCount() {
   $connect = connect();

    $sql = "SELECT COUNT(*) AS total FROM articles";
    $stmt = $connect->prepare($sql);
    
    // Exécution de la requête
    $stmt->execute();
    
    // Obtention du résultat
    $result = $stmt->get_result();
    
    // Récupération du nombre total d'articles à partir du résultat
    $row = $result->fetch_assoc();
    $total = $row['total'];
    
    // Fermeture de la connexion et retour du nombre total d'articles
    $stmt->close();
    $connect->close();
    return $total;
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

function insertArticle($titre, $categorie_id, $user_id,$contenu, $image) {
    $connect = connect();

    // Préparez la requête SQL pour insérer un nouvel article
    $sql = "INSERT INTO articles (titre, categorie_id, user_id,contenu, image) VALUES (?, ?, ?, ?, ?)";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("siiss", $titre, $categorie_id, $user_id, $contenu, $image);

    // Exécutez la déclaration
    $stmt->execute();

    // Fermez la déclaration et la connexion
    $stmt->close();
    $connect->close();
}

function insertCategorie($nom_categorie) {
    $connect = connect();

    // Préparez la requête SQL pour insérer un nouvel article
    $sql = "INSERT INTO categories (nom_categorie) VALUES (?)";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("s", $nom_categorie);

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