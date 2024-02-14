<?php

include '../const/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['nom_utilisateur'];
    $password = $_POST['mot_de_passe'];

    if (authentifier_user($username, $password)) {
        header("Location: ../pages/admin/index.php");
        exit();
    } else {
        echo "<script>showIncorrectCredentialsError();</script>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
        }

        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
        }

        .card-body {
            padding: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="text-center text-success">CONNEXION</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="username" name="nom_utilisateur">
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="mot_de_passe">
                            </div>
                            <!-- Appelle la fonction JavaScript lors du clic sur le bouton -->
                            <button type="button" class="btn btn-success btn-block" onclick="submitForm()">Se connecter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showEmptyFieldsError() {
            Swal.fire({
                title: '',
                text: 'Veuillez remplir tous les champs !',
                icon: 'error'
            });
        }

        function showIncorrectCredentialsError() {
            alert("Nom d'utilisateur ou mot de passe incorrect!");
        }

        function submitForm() {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            if(username.trim() !== '' && password.trim() !== '') {
                document.querySelector('form').submit();
            } else {
                showEmptyFieldsError();
            }
        }
    </script>

</body>
</html>
