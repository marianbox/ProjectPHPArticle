<?php //////////bienvenue dans le formulaire pour ajouter des articles
?>

<?php require_once 'config/init.conf.php'; ?>


<?php
if (isset($_POST['submit'])) {

    //$_POST['mdp'] = sha1(sha1($_POST['email']).sha1($_POST['mdp']).sha1($salt));



    //print_r2($_POST);
    // print_r2($_FILES);
    // exit();
    $utilisateurs = new utilisateurs();
    $utilisateurs->hydrate($_POST);

    $utilisateurs->setmdp(password_hash($utilisateurs->getmdp(), PASSWORD_DEFAULT));

    //// OSKOUR $utilisateurs->setDate(date('Y-m-d'));


    ///// OSKOUR $publie = $utilisateurs->getPublie() === 'on' ? 1 : 0; // Condition ternaire. Si $publie = on, publie vaut 1 sinon il vaut 0.


    // Insertion ou mise à jour de l'article.
    $utilisateursManager = new utilisateursManager($bdd);
    $utilisateursManager->addUtilisateurs($utilisateurs);

    //var_dump($utilisateursManager)



    if ($utilisateursManager->get_result() == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'votre utilisateur est ajouter';
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'une erreur est survenue pendant la creation';
    }



    header("Location: index.php"); ///Retour a l'index apres avoir creer le fichier
    exit();
} else {

    $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
    $twig = new \Twig\Environment($loader, ['debug' => true]);

    //  echo $twig->render('FormUtilisateurs.php', ['the' => 'variables', 'go' => 'here']);
    echo $twig->render('FormUtilisateurs.html.twig')



?>



<?php
}
?>