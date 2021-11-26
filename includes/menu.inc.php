        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="index.php">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                        <?php if (isset($_COOKIE['sid'])) { ?>
                            <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="FormArticles.php">Ajouter un article</a></li>
                            <li class="nav-item"><a class="nav-link" href="deconnexion.php">Déconnexion</a></li>
                        <?php } else { ?>
                            <li class="nav-item"><a class="nav-link" href="FormUtilisateurs.php">S'inscrire</a></li>
                            <li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
                        <?php }
                        ?>

                    </ul>
                </div>
            </div>
        </nav>