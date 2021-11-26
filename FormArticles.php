<?php //////////bienvenue dans le formulaire pour ajouter des articles
?>

<?php require_once 'config/init.conf.php'; ?>


<?php
if (isset($_POST['submit'])) {
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
    $articlesManager->addArticles($articles);

    //var_dump($articlesManager)

    // Traitement de l'image

    if ($_FILES['image']['error'] == 0) {
        $fileInfos = pathinfo($_FILES['image']['name']); ///ont regarde les infos l'image recupere 
        move_uploaded_file(
            $_FILES['image']['tmp_name'], ///ont recup en memoire l'image ajouter

            'img/' . $articlesManager->get_getLastInsertId() ///ont place l'image upload dans le dossier img et ont recup le dernier ID de l'article creer
                . '.' . $fileInfos['extension']
        ); ///ont renomme l'image par le dernier id et ont lui rajoute l'extension   


    }
    if ($articlesManager->get_result() == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'votre article est ajouter';
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'une erreur est survenue pendant la creation';
    }






    header("Location: index.php"); ///Retour a l'index apres avoir creer le fichier
    exit();
} else {


    $utilisateurs = new utilisateurs;
    $utilisateursManager = new utilisateursManager($bdd);

    $sid = $utilisateurs->getsid();
    ////////////////////////////// C'EST ICI QU JE CHARGE MON TWIG////////////////////

    $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
    $twig = new \Twig\Environment($loader, ['debug' => true]);

    //  echo $twig->render('FormUtilisateurs.php', ['the' => 'variables', 'go' => 'here']);
    echo $twig->render('FormArticles.html.twig', ['result' => $result, 'message' => $message, 'session' => $_SESSION, 'sid' => $sid])



?>






    <?php

}
    ?>