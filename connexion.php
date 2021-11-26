<?php //////////bienvenue dans le formulaire pour ajouter des articles
?>

<?php require_once 'config/init.conf.php'; ?>


<?php
if (isset($_POST['save'])) {


    //print_r2($_POST);
    // print_r2($_FILES);
    // exit();
    $utilisateurs = new utilisateurs();
    $utilisateurs->hydrate($_POST);

    print_r2($utilisateurs);
    // exit();

    $utilisateursManager = new utilisateursManager($bdd);
    $utilisateursEnBdd = $utilisateursManager->getbyemail($utilisateurs->getemail());

    $isConnect = password_verify($utilisateurs->getmdp(), $utilisateursEnBdd->getmdp());

    var_dump($isConnect);
    // exit();


    if ($isConnect == true) {
        $sid = md5($utilisateurs->getemail() . time());
        setcookie('sid', $sid, time() + 800000);
        $utilisateurs->setsid($sid);
        $utilisateursManager->updatebyemail($utilisateurs);
    }

    //var_dump($utilisateursManager)




    if ($utilisateursManager->get_result() == true) {
        header("Location: index.php");
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'votre utilisateur est connecter';
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'une erreur est survenue pendant la connection';
        header("Location: connexion.php");
    }



    ///Retour a l'index apres avoir creer le fichier
    exit();
} else {



    /*$loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
        $twig = new \Twig\Environment($loader, [ 'debug' => true]);

      //  echo $twig->render('FormUtilisateurs.php', ['the' => 'variables', 'go' => 'here']);
        echo $twig->render('connexion.html.twig',['result' => $result , 'message' => $message , 'session' => $_SESSION]);
    */

?>
    <!DOCTYPE html>
    <html lang="en">
    <?php include 'includes/header.inc.php'; ?>



    <body>
        <!-- Responsive navbar-->
        <?php include 'includes/menu.inc.php'; ?>


        <!-- Page Content-->
        <div class="container px-4 px-lg-5">
            <!-- Heading Row-->
            <div class="row gx-4 gx-lg-5 align-items-center my-5">

                <div class="col-12">
                    <h1 class="font-weight-light"><?php echo "Bienvenue dans le formulaire pour vous connecter" ?></h1>
                    <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>

                </div>
            </div>




            <?php
            if (isset($_SESSION['notification'])) {
            ?>

                <div class="alert alert-<?= $_SESSION['notification']['result'] ?> alert-dismissible mt-3 " role="alert">
                    <?= $_SESSION['notification']['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php
                unset($_SESSION['notification']);
            }
            ?>




            <!-- Content Row-->
            <!-- Formulaire-->
            <form method=POST id="utilisateursForm" action="connexion.php" enctype="multipart/form-data">



                <!-- email-->
                <div class="mb-3">
                    <label for="texte" class="form-label">email</label>
                    <input type="email" name="email" class="form-control" id="texte" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text"></div>
                </div>



                <!-- mdp-->
                <div class="mb-3">
                    <label for="texte" class="form-label">mdp</label>
                    <input type="password" name="mdp" class="form-control" id="texte" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text"></div>
                </div>




                <br><br>




                <button type="submit" class="btn btn-primary" name="save">se connecter</button>
            </form>




            <?php
            /*
                /////montrer l'article ajouter grace au formulaire
                print_r2($_POST);
                print_r2($_FILES);*/
            ?>


            <br>

        </div>





        <!-- Footer-->
        <?php include 'includes/footer.inc.php'; ?>
    </body>

    </html>

<?php
}
//print_r2($_POST['save']);

?>