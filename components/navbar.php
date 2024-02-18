<nav class="navbar navbar-expand-lg navbar-light bg-body-secondary ">
        <div class="container-fluid navbar-custom-young flex-column ">
            <!-- Brand -->
            <div>
                <a href="index.php" class="text-black navbar-brand">LES PARTISANS DE PENSÉE</a>
            </div>
            <!-- Toggle Button for Small Screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="tous_les_articles.php">Tous les articles</a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            foreach ($categories as $categorie) {
                                echo "<li><a href='articles_par_categorie.php?categorie_id=" . $categorie['id_categorie'] . "' class='dropdown-item'> Articles " . $categorie['nom_categorie'] . "</a></li>";
                            }
                            ?>
                        </ul>
                    </li>

                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLanguage" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Language
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownLanguage">
                            <li><a class="dropdown-item" href="#">FR</a></li>
                            <li><a class="dropdown-item" href="#">AR</a></li>
                        </ul>
                    </li> -->

                    <li class="nav-item">
                        <a class="nav-link" href="../auth/login.php"><i class="fas fa-user"></i></a>
                    </li>
                </ul>

                <!-- User Icon -->
                <!-- <ul class="navbar-nav">
               
                </ul> -->

            </div>

        </div>
    </nav>