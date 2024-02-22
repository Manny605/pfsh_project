<nav class="navbar navbar-expand-lg navbar-light bg-danger-subtle">
    <div class="container-fluid navbar-custom-young flex-column">
        <!-- Brand -->
        <div>
            <a href="index_ang.php" class="text-black navbar-brand">Supporters of Thought</a>
        </div>
        <!-- Toggle Button for Small Screens -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="flex collapse navbar-collapse justify-content-between mt-4" id="navbarSupportedContent">

            <!-- Barre de recherche -->
            <div class="me-4">
                <form class="d-flex" action="tous_les_articles_ang.php" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Search..." aria-label="Rechercher" name="q">
                    <button class="btn btn-outline-danger" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>

            <div class="d-flex align-items-center">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 me-4">
                    <li class="nav-item">
                        <a class="nav-link" href="tous_les_articles_ang.php">All Articles</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            foreach ($categories as $categorie) {
                                echo "<li><a href='articles_par_categorie_ang.php?categorie_id=" . $categorie['id_categorie'] . "' class='dropdown-item'>" . $categorie['nom_categorie_ang'] . " Articles</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLanguage" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Language
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownLanguage">
                            <li><a href='../Fr/index.php' class='dropdown-item'>French</a></li>
                            <li><a href='../Ar/index_ar.php' class='dropdown-item'>Arabic</a></li>
                            <li><a href='index_ang.php' class='dropdown-item'>English</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="../../auth/login.php"><i class="fas fa-user"></i></a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>
