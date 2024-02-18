<?php

session_start();
if (!isset($_SESSION['id_user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../../index.php");
    exit();
}

include '../../../const/functions.php';

$users = getAllUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin : Utilisateurs</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 56px;
        }
        @media (min-width: 768px) {
            body {
                padding-top: 72px;
            }
        }
        @media (max-width: 480px) {
            .mobile-only{
                display: none;
            }
        }
    </style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Administrateur</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Tableau de bord</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../articles/articles.php">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../categories/categories.php">Categories</a>
                </li>
                <?php if ($_SESSION['role'] !== 'auteur'): ?>
                <li class="nav-item active">
                    <a class="nav-link" href="utilisateurs.php">Utilisateurs</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../const/deconnexion.php">Deconnecter</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col">
                        <h2>Liste des utilisateurs</h2>
                    </div>
                </div>
                <div class="row justify-content-end mb-4">
                    <div class="col-auto">
                        <a href="" data-toggle="modal" data-target="#addModal" class="btn btn-primary ml-auto ">Ajouter</a>
                    </div>
                </div>

                <hr>
                                
                <?php
                    if (isset($_GET['success_ajout']) && $_GET['success_ajout'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                            L\'utilisateur a été ajouté avec succès.
                        </div>';
                    } elseif (isset($_GET['error_ajout'])) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Une erreur inconnue s\'est produite.';
                        echo '</div>';
                    }

                    if (isset($_GET['success_modif']) && $_GET['success_modif'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                            L\'utilisateur a été mis à jour avec succès.
                        </div>';
                    }
                    // } elseif (isset($_GET['error_modif'])) {
                    //     echo '<div class="alert alert-danger" role="alert">';
                    //     echo 'Une erreur inconnue s\'est produite.';
                    //     echo '</div>';
                    // }
                    if (isset($_GET['success_supp']) && $_GET['success_supp'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                            L\'utilisateur a été supprimé avec succès.
                        </div>';
                    } elseif (isset($_GET['error_supp'])) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Une erreur inconnue s\'est produite.';
                        echo '</div>';
                    }
                ?>
                <!-- Main Content -->
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="mobile-only"></th>
                            <th>Nom</th>
                            <th class="mobile-only">Nom_utilisateur</th>
                            <th class="mobile-only">Mot de passe</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $increment = 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="mobile-only"><?php echo $increment; ?></td>
                                <td><?php echo $user['prenom'] . ' ' . $user['nom']; ?></td>
                                <td class="mobile-only"><?php echo $user['nom_utilisateur']; ?></td>
                                <td class="mobile-only"><?php echo $user['mot_de_passe']; ?></td>
                                <td class="row">
                                    <a href="" data-toggle="modal" data-target="#editModal<?php echo $user['id_user']; ?>"><i class="px-4 fas fa-edit text-success"></i></a>
                                    <a href="" data-toggle="modal" data-target="#deleteModal<?php echo $user['id_user']; ?>"><i class="fas fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                            <?php $increment++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>




            <!-- Modal Delete pour chaque article -->
            <?php foreach($users as $index => $user): ?>
                <div class="modal fade" id="deleteModal<?php echo $user['id_user']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Supprimer l'utilisateur</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <a href="supprimer_utilisateur.php?id=<?php echo $user['id_user']; ?>" class="btn btn-danger">Supprimer</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        <!-- Bouton Ajouter Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Ajouter un utilisateur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="ajout_utilisateur.php" method="post">
                            <div class="form-group">
                                <label for="nom_categorie">Prenom</label>
                                <input type="text" class="form-control" id="nom_categorie" name="prenom" required>
                            </div>
                            <div class="form-group">
                                <label for="nom_categorie">Nom</label>
                                <input type="text" class="form-control" id="nom_categorie" name="nom" required>
                            </div>
                            <div class="form-group">
                                <label for="nom_categorie">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="nom_categorie" name="nom_utilisateur" required>
                            </div>
                            <div class="form-group">
                                <label for="mot_de_passe">Mot de passe</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Modification pour chaque catégorie -->
        <?php foreach($users as $user): ?>
            <div class="modal fade" id="editModal<?php echo $user['id_user']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $user['id_user']; ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel<?php echo $user['id_user']; ?>">Modifier l'utilisateur</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="modifier_utilisateur.php" method="post">
                                <input type="hidden" name="id_user" value="<?php echo $user['id_user']; ?>">
                                <div class="form-group">
                                    <label for="nom_categorie">Prenom</label>
                                    <input type="text" class="form-control" id="nom_utilisateur" name="prenom" value="<?php echo $user['prenom']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nom_categorie">Nom</label>
                                    <input type="text" class="form-control" id="nom_utilisateur" name="nom" value="<?php echo $user['nom']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nom_categorie">Nom d'utilisateur</label>
                                    <input type="text" class="form-control" id="nom_utilisateur" name="nom_utilisateur" value="<?php echo $user['nom_utilisateur']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="mot_de_passe">Mot de passe</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="mot_de_passe_mdp" name="mot_de_passe" value="<?php echo $user['mot_de_passe'] ?>" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword_modif">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            var passwordField = document.getElementById('mot_de_passe');
            var fieldType = passwordField.getAttribute('type');
            if (fieldType === 'password') {
                passwordField.setAttribute('type', 'text');
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordField.setAttribute('type', 'password');
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });

        document.getElementById('togglePassword_modif').addEventListener('click', function() {
            var passwordField = document.getElementById('mot_de_passe_mdp');
            var fieldType = passwordField.getAttribute('type');
            if (fieldType === 'password') {
                passwordField.setAttribute('type', 'text');
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordField.setAttribute('type', 'password');
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    </script>
</body>
</html>