<?php //////////bienvenue dans le formulaire pour ajouter des articles
?>

<?php require_once 'config/init.conf.php'; ?>


<?php ////Recup ID du formualire
$arctl = NULL;
if (isset($_GET['formulaire'])) {
    $articlesManager = new articlesManager($bdd);
    $arctl = $articlesManager->getArticleById(htmlspecialchars($_GET['formulaire']));
}


?>


<?php
if (isset($_GET["formulaire"])) {
    $id_articles = $_GET["formulaire"];
    $articlesManager = new articlesManager($bdd);
    $a = $articlesManager->getArticleById($id_articles);

    if ($a->getPublie() == 0) {
        $publie = "";
    } else {
        $publie = "checked";
    }
}


?>






<?php
if (isset($_POST['delete'])) {
    //print_r2($_POST);
    // print_r2($_FILES);
    // exit();
    $articles = new articles();
    $articles->hydrate($_POST);

    $articles->setDate(date('Y-m-d'));


    $publie = $articles->getPublie() === 'on' ? 1 : 0; // Condition ternaire. Si $publie = on, publie vaut 1 sinon il vaut 0.
    $articles->setPublie($publie);

    // Insertion ou mise à jour de l'article.
    $articlesManager = new articlesManager($bdd);
    $articlesManager->DeleteArticles($articles);

    //var_dump($articlesManager)

    // Traitement de l'image


    if ($articlesManager->get_result() == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'votre article est Supprimer';
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'une erreur est survenue pendant la supression';
    }



    header("Location: index.php"); ///Retour a l'index apres avoir creer le fichier
    exit();
} else {
    $commentairesManager = new commentairesManager($bdd);
    $ListCommentaires = $commentairesManager->getListCommentaires2($id_articles);


    $utilisateurs = new utilisateurs;
    $utilisateursManager = new utilisateursManager($bdd);

    $sid = $utilisateurs->getsid();

    $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
    $twig = new \Twig\Environment($loader, ['debug' => true]);

    //  echo $twig->render('FormUtilisateurs.php', ['the' => 'variables', 'go' => 'here']);
    echo $twig->render('FormDeleteArticles.html.twig', ['articles' => $arctl, 'ListCommentaires' => $ListCommentaires, 'sid' => $sid]);



?>


    <?php
}

    ?>