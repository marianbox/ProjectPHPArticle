<?php //////////bienvenue dans le formulaire pour ajouter des articles
?>

<?php require_once 'config/init.conf.php'; ?>


<?php ////Recup ID du commentaires et de l'article formualaire
$arctl = NULL;
$comment = NULL;

if (isset($_GET['formulaire'])) {
    $articlesManager = new articlesManager($bdd);
    $commentairesManager = new commentairesManager($bdd);

    $utilisateurs = new utilisateurs;
    $utilisateursManager = new utilisateursManager($bdd);

    $sid = $utilisateurs->getsid();

    $arctl = $articlesManager->getArticleById(htmlspecialchars($_GET['formulaire']));
    $comment = $commentairesManager->getCommentairesById(htmlspecialchars($_GET['formulaire']));
    $id_articles = $_GET["formulaire"];
}


?>







<?php
if (isset($_POST['AddComment'])) {
    //print_r2($_POST);
    // print_r2($_FILES);
    // exit();
    $commentaires = new commentaires();
    $commentaires->hydrate($_POST);




    // Insertion ou mise à jour de l'article.
    $commentairesManager = new commentairesManager($bdd);
    $commentairesManager->addCommentaires($commentaires);

    //var_dump($articlesManager)

    // Traitement de l'image


    if ($commentairesManager->get_result() == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'votre commentaires est ajouter';
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'une erreur est survenue pendant ajout du commentaires';
    }



    header("Location: index.php"); ///Retour a l'index apres avoir creer le fichier
    exit();
} else {


    $commentairesManager = new commentairesManager($bdd);
    $ListCommentaires = $commentairesManager->getListCommentaires2($id_articles);


    $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
    $twig = new \Twig\Environment($loader, ['debug' => true]);

    //  echo $twig->render('FormUtilisateurs.php', ['the' => 'variables', 'go' => 'here']);
    echo $twig->render('PageArticles.html.twig', ['articles' => $arctl, 'ListCommentaires' => $ListCommentaires, 'sid' => $sid]);
}
?>




<?php


/*
    foreach ($ListCommentaires as $key => $commentaires){
    ?>

<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 hidden class="card-title" name=id_articles><?= $commentaires->getid_articles();?></h5>
        <h5 class="card-title"><?= $commentaires->getpseudo();?></h5>
        <h1 class="card-title"><?= $commentaires->getemail();?></h1>
        <p class="card-text"><?= $commentaires->getcommentaires_texte();?></p>
    </div>
</div>
<?php
    }
  ?>

<?php 
} 
*/
?>