        <?php
        require_once 'config/init.conf.php';
        //print_r2($_SESSION);
        ?>



        <?php
        $articles = new articles();

        $articles->setTitre('mon titre');

        $tab = [
            'id' => 1,
            'titre' => 'mon titre',
        ];
        $articles->hydrate($tab);
        // print_r2($articles);
        ?>



        <?php
        ////////////////MONTRER CE QU'IL Y A DANS ARTICLES MANAGER PAR RAPPORT A L'id
        // echo ("rechercher par rapport a l'id");
        $articlesManager = new articlesManager($bdd);
        $articles = $articlesManager->getArticleById(1);
        // print_r2($articles);
        ?>




        <?php
        ////////////////MONTRER la liste d'article
        $articlesManager = new articlesManager($bdd);
        $ListArticles = $articlesManager->getListArticles2();
        // print_r2($articles);
        ?>




        <?php

        /*PREMIER TEST 

                ////////////////MONTRER l'index du tableau et celui de la page et fait en sorte a ce qu'il correspondent a un model de 2 article par page

                ////recup les données de l'url avec un $get qu'ont met dans une variable $page exemple salut.com/lpcours/?p=1 le programme va afficher lalala1
            $page = $_GET['p']; ///ceci est la page sur laquelle vous etes

                //////////constante
            define('__nb_articles_par_page', 2);///ont defini une constante
            echo 'bienvenue sur la page '.$page; ///ont echo pour savoir sur qu'elle page ont est (?p=1 dans l'url)

            $resultat = ($page -1) * __nb_articles_par_page; ///calcul pour mettre le bon index du tableau a la bonne page (2 par 2)
            echo 'nous sommes sur lindex du tableau numero : '.$resultat; //l'index du tableau ou nous sommes (regarde le tableau qu'il y a dans le fichier explication)

            */
        ?>


        <?php
        define('__nb_articles_par_page', 2);
        $page = !empty($_GET['p']) ? $_GET['p'] : 1; /////////si la page n'a pas de parametre alors la page vaut 1///////////


        $nbArticlesTotalLAPublie = $articlesManager->countArticlesPublie();
        $nbpage = ceil($nbArticlesTotalLAPublie / __nb_articles_par_page);



        $indexDepart = ($page - 1) * __nb_articles_par_page;

        $ListArticles = $articlesManager->getListArticles3($indexDepart, __nb_articles_par_page);

        ?>

        <?php
        /////////////////Barre de Recherche
        if (isset($_GET["terme"])) {
            ////////////////MONTRER la liste d'article
            $articlesManager = new articlesManager($bdd);
            $ListArticles = $articlesManager->getListArticlesFromRecherche($_GET["terme"]);
            //print_r2($ListArticles);
        }






        if (isset($_COOKIE['sid'])) {
            $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
            $twig = new \Twig\Environment($loader, ['debug' => true]);

            //  echo $twig->render('FormUtilisateurs.php', ['the' => 'variables', 'go' => 'here']);
            echo $twig->render('index.html.twig', ['articles' => $articles, 'ListArticles' => $ListArticles, 'sid' => $_COOKIE['sid']]);
        } else {
            $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
            $twig = new \Twig\Environment($loader, ['debug' => true]);

            //  echo $twig->render('FormUtilisateurs.php', ['the' => 'variables', 'go' => 'here']);
            echo $twig->render('index.html.twig', ['articles' => $articles, 'ListArticles' => $ListArticles]);
        }



        ?>






        <?php
        //////////////////////////////////PAGINATION AUTO INCREMENT
        ?>
        <div class="row mt-3">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">

                        <?php for ($index = 1; $index <= $nbpage; $index++) { ?>
                            <li class="page-item <?php if ($page == $index) { ?>active<?php } ?>">
                                <a class="page-link" href="index.php?p=<?= $index ?>"><?= $index ?></a>
                            </li>
                        <?php
                        } ?>


                    </ul>
                </nav>
            </div>


        </div>





        </div>





        <!-- Footer-->
        <?php include 'includes/footer.inc.php'; ?>
    </body>

</html>