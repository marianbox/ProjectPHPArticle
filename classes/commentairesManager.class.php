<?php

class commentairesManager
{
    //DECLARATION ET INSTANCIATION
    public $bdd; //Instance de PDO
    public $_result;
    public $_message;
    public $_commentaires; //instance de l'commentaires
    public $_getLastInsertId;

    public function __construct(PDO $bdd)
    {
        $this->setBdd($bdd);
    }


    function getBdd()
    {
        return $this->bdd;
    }

    function get_result()
    {
        return $this->_result;
    }

    function get_message()
    {
        return $this->_message;
    }

    function get_commentaires()
    {
        return $this->_commentaires;
    }

    function get_getLastInsertId()
    {
        return $this->_getLastInsertId;
    }

    ////////////SET

    function setBdd($bdd)
    {
        $this->bdd = $bdd;
    }

    function set_result($_result)
    {
        $this->_result = $_result;
    }

    function set_message($_message)
    {
        $this->_message = $_message;
    }

    function set_commentaires($_commentaires)
    {
        $this->_commentaires = $_commentaires;
    }

    function set_getLastInsertId($_getLastInsertId)
    {
        $this->_getLastInsertId = $_getLastInsertId;
    }



    /////////////JE GET un  commentaires A PARTIR DE LID
    public function getCommentairesById($id)
    {
        //prepare une requete de type select avec une clause WHERE  
        $sql = 'SELECT * FROM commentaires WHERE id = :id';
        $req = $this->bdd->prepare($sql);

        //////execution de la requete avec attribution des valeurs
        $req->bindValue(':id', $id, PDO::PARAM_INT); ///param init va permettre de verifier si ce qu'ont rentre comme données correspond bien a un INT sinon le programme renvoie une erreur
        $req->execute();

        /////on stocke les données obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        $commentaires = new commentaires();
        $commentaires->hydrate($donnees);
        ////print r2($commentaires);
        return $commentaires;
    }





    /////////////////je GET une LIST Commentaires par rapport a un article (PageArticles)

    public function getListCommentaires2($id_articles)
    {
        $listCommentaires = []; ///on creer une liste vide ou ont mettra tous les commentaires


        //prepare une requete de type select
        $sql = 'SELECT * FROM commentaires WHERE id_articles = :id_articles';


        $req = $this->bdd->prepare($sql);

        //////execution de la requete avec attribution des valeurs
        $req->bindValue(':id_articles', $id_articles, PDO::PARAM_INT);
        $req->execute();

        /////on stocke les données obtenues dans un tableau
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) { ///tant que il y a des commentaires alors on boucle
            ////on cree des objets avec les données issue de la bdd
            $commentaires = new commentaires();
            $commentaires->hydrate($donnees);
            $listCommentaires[] = $commentaires;
        }
        ///print_r2($listCommentaires)
        return $listCommentaires;
    }


    

    /////////////////je GET une LIST Commentaires par rapport a un article mais avec une jointures

    public function getListCommentairesJointures($id_articles)
    {
        $listCommentaires = []; ///on creer une liste vide ou ont mettra tous les commentaires


        //prepare une requete de type select
        $sql = 'SELECT * FROM commentaires as co INNER JOIN articles as ar ON ar.id = co.id_articles  WHERE co.id_articles = :id_articles';


        $req = $this->bdd->prepare($sql);

        //////execution de la requete avec attribution des valeurs
        $req->bindValue(':id_articles', $id_articles, PDO::PARAM_INT);
        $req->execute();

        /////on stocke les données obtenues dans un tableau
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) { ///tant que il y a des commentaires alors on boucle
            ////on cree des objets avec les données issue de la bdd
            $commentaires = new commentaires();
            $commentaires->hydrate($donnees);
            $listCommentaires[] = $commentaires;
        }
        ///print_r2($listCommentaires)
        return $listCommentaires;
    }




///////////ajouter un commentaire (pageArticles)


    public function addCommentaires(commentaires $commentaires)
    {
        $sql = "INSERT INTO commentaires "
            . "(id_articles, pseudo, email, commentaires_texte)"
            . "VALUES (:id_articles, :pseudo , :email , :commentaires_texte)";
        $req = $this->bdd->prepare($sql); // Prépare la requette en ayant effectuer la connexion au préalable
        $req->bindValue(':id_articles', $commentaires->getid_articles(), PDO::PARAM_INT);
        $req->bindValue(':pseudo', $commentaires->getpseudo(), PDO::PARAM_STR);
        $req->bindValue(':email', $commentaires->getemail(), PDO::PARAM_STR);
        $req->bindValue(':commentaires_texte', $commentaires->getcommentaires_texte(), PDO::PARAM_STR);

        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            $this->_getLastInsertId = $this->bdd->lastInsertId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

    /////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////FEATURES
    /////////////////////////////////////////////////////////////////

    ////////////////UPDATE Article
    /*
public function update(commentaires $commentaires) {
    $sql = 'UPDATE commentaires SET '
            . 'titre = :titre, '
            . 'texte = :texte, '
            . 'publie = :publie '
            . "WHERE id = :id";


    $req = $this->bdd->prepare($sql);
    // Sécurisation des variables
    $req->bindValue(':titre', $commentaires->getTitre(), PDO::PARAM_STR);
    $req->bindValue(':texte', $commentaires->getTexte(), PDO::PARAM_STR);
    $req->bindValue(':publie', $commentaires->getPublie(), PDO::PARAM_STR);
    $req->bindValue(':id', $commentaires->getId(), PDO::PARAM_STR);
    
    $req->execute();
    if ($req->errorCode() == 00000) {
        $this->_result = true;
        //$this->_getLastInsertId = $commentaires->getId();
    } else {
        $this->_result = false;
    }
    return $this;
}
*/


    /*
public function countCommentaires(){
    $sql = "SELECT COUNT(*) as total FROM commentaires";
    $req = $this->bdd->prepare($sql);
    $req->execute();
    $count = $req->fetch(PDO::FETCH_ASSOC);
    $total = $count['total'];
    return $total;
}
*/




    /*public function getListCommentairesFromRecherche($recherche) {
    $listCommentaires = [];
    
    // Prépare une requête de type SELECT avec un clause WHERE selon la recherche.
    $sql = 'SELECT * '
            . 'FROM commentaires '
            . 'WHERE publie = 1 '
            . 'AND (titre LIKE :recherche '
            . 'OR texte LIKE :recherche)';

    $req = $this->bdd->prepare($sql);
    $req->bindValue(':recherche', "%" . $recherche . "%", PDO::PARAM_STR);
    $req->execute();
    
    // On stock les données dans un tableau
    while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
        // On crée des objets avec les données issus de la table.
        $commentaires = new commentaires();
        $commentaires->hydrate($donnees);
        $listCommentaires[] = $commentaires;            
    }
    // print_r2($listCommentaires);
    return $listCommentaires;
}

*/


    /*public function getSearchCommentaires($titre){
    //prepare une requete de type select avec une clause WHERE  
    $sql='SELECT * FROM commentaires WHERE titre = :titre';
    $req = $this->bdd->prepare($sql);

//////execution de la requete avec attribution des valeurs
$req->bindValue(':titre', $titre, PDO::PARAM_STR); ///param init va permettre de verifier si ce qu'ont rentre comme données correspond bien a un INT sinon le programme renvoie une erreur
$req->execute();

/////on stocke les données obtenues dans un tableau
$donnees = $req->fetch(PDO::FETCH_ASSOC);
$commentaires = new commentaires();
$commentaires->hydrate($donnees);
////print r2($commentaires);
return $commentaires;

}

*/



    /*public function add(commentaires $commentaires){
    $sql = "INSERT INTO commentaires" .
    "(titre,texte,publie,date)"
}*/



    /*public function DeleteCommentaires(commentaires $commentaires) {
    $sql = 'DELETE FROM commentaires WHERE id = :id';

    $req = $this->bdd->prepare($sql);
    // Sécurisation des variables
    $req->bindValue(':id', $commentaires->getId(), PDO::PARAM_INT);
    
    $req->execute();
    if ($req->errorCode() == 00000) {
        $this->_result = true;
        //$this->_getLastInsertId = $commentaires->getId();
    } else {
        $this->_result = false;
    }
    return $this;
}

*/

    ////////////////AFFICHER LISTE DES commentaires 

    /*public function getList(){
    $listCommentaires =[]; ///on creer une liste vide ou ont mettra tous les commentaires


    //prepare une requete de type select
    $sql='SELECT * FROM commentaires';
    $req = $this->bdd->prepare($sql);

    //execution de la requete avec attribution des valeurs
    $req->execute();

    /////on stocke les données obtenues dans un tableau
    while ($donnees = $req->fetch(PDO::FETCH_ASSOC)){///tant que il y a des commentaires alors on boucle
    ////on cree des objets avec les données issue de la bdd
    $commentaires = new commentaires();
    $commentaires->hydrate($donnees);
    $listCommentaires[] = $commentaires;
    }
    ///print_r2($listCommentaires)
    return $listCommentaires;

}
*/
}
