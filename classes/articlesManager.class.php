<?php

class articlesManager
{
    //DECLARATION ET INSTANCIATION
    public $bdd; //Instance de PDO
    public $_result;
    public $_message;
    public $_articles; //instance de l'articles
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

    function get_articles()
    {
        return $this->_articles;
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

    function set_articles($_articles)
    {
        $this->_articles = $_articles;
    }

    function set_getLastInsertId($_getLastInsertId)
    {
        $this->_getLastInsertId = $_getLastInsertId;
    }






    /////////////JE GET LARTICLE A PARTIR DE LID
    public function getArticleById($id)
    {
        //prepare une requete de type select avec une clause WHERE  
        $sql = 'SELECT * FROM articles WHERE id = :id';
        $req = $this->bdd->prepare($sql);

        //////execution de la requete avec attribution des valeurs
        $req->bindValue(':id', $id, PDO::PARAM_INT); ///param init va permettre de verifier si ce qu'ont rentre comme données correspond bien a un INT sinon le programme renvoie une erreur
        $req->execute();

        /////on stocke les données obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        $articles = new articles();
        $articles->hydrate($donnees);
        ////print r2($articles);
        return $articles;
    }







    ////////////////AFFICHER LISTE DES ARTICLES
    public function getListArticle()
    {
        $listArticles = []; ///on creer une liste vide ou ont mettra tous les articles


        //prepare une requete de type select
        $sql = 'SELECT * FROM articles';
        $req = $this->bdd->prepare($sql);

        //////execution de la requete avec attribution des valeurs
        $req->execute();

        /////on stocke les données obtenues dans un tableau
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) { ///tant que il y a des article alors on boucle
            ////on cree des objets avec les données issue de la bdd
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticles[] = $articles;
        }
        ///print_r2($listArticles)
        return $listArticles;
    }





    /////////////////GET LIST AVEC DATE EN FRANCAIS

    public function getListArticles2()
    {
        $listArticles = []; ///on creer une liste vide ou ont mettra tous les articles


        //prepare une requete de type select
        $sql = 'SELECT id, '
            . 'titre, '
            . 'texte, '
            . 'publie, '
            . 'DATE_FORMAT(date, "%d/%m/%Y")as date '
            . 'FROM articles ';


        $req = $this->bdd->prepare($sql);

        //////execution de la requete avec attribution des valeurs
        $req->execute();

        /////on stocke les données obtenues dans un tableau
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) { ///tant que il y a des article alors on boucle
            ////on cree des objets avec les données issue de la bdd
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticles[] = $articles;
        }
        ///print_r2($listArticles)
        return $listArticles;
    }




    ////getlist avec limite de 2 article par page
    public function getListArticles3($depart, $limit)
    {
        $listArticles = []; ///on creer une liste vide ou ont mettra tous les articles
        $publie = 1;

        //prepare une requete de type select
        $sql = 'SELECT id, '
            . 'titre, '
            . 'texte, '
            . 'publie, '
            . 'DATE_FORMAT(date, "%d/%m/%Y")as date '
            . 'FROM articles '
            . 'WHERE publie = 1 '
            . 'LIMIT :depart, :limit';

        $req = $this->bdd->prepare($sql);

        $req->bindValue(':depart', $depart, PDO::PARAM_INT);
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);

        //////execution de la requete avec attribution des valeurs
        $req->execute();

        /////on stocke les données obtenues dans un tableau
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) { ///tant que il y a des article alors on boucle
            ////on cree des objets avec les données issue de la bdd
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticles[] = $articles;
        }
        ///print_r2($listArticles)
        return $listArticles;
    }



    /////Count les articles Publier
    public function countArticlesPublie()
    {
        $sql = "SELECT COUNT(*) as total FROM articles WHERE publie = 1";
        $req = $this->bdd->prepare($sql);
        $req->execute();
        $count = $req->fetch(PDO::FETCH_ASSOC);
        $total = $count['total'];
        return $total;
    }

///////Ajouter des articles dans la bdd (page AddArticles)
    public function addArticles(articles $articles)
    {
        $sql = "INSERT INTO articles "
            . "(titre, texte, date, publie)"
            . "VALUES (:titre, :texte , :date , :publie)";
        $req = $this->bdd->prepare($sql); // Prépare la requette en ayant effectuer la connexion au préalable
        $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':date', $articles->getDate(), PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_INT);

        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            $this->_getLastInsertId = $this->bdd->lastInsertId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

///////Mise a jours d'un articles dans la bdd (pageUpdateArticle)
    public function updateArticles(articles $articles)
    {
        $sql = 'UPDATE articles SET '
            . 'titre = :titre, '
            . 'texte = :texte, '
            . 'publie = :publie '
            . 'WHERE id = :id';


        $req = $this->bdd->prepare($sql);
        // Sécurisation des variables
        $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_STR);
        $req->bindValue(':id', $articles->getId(), PDO::PARAM_INT);

        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            //$this->_getLastInsertId = $articles->getId();
        } else {
            $this->_result = false;
        }
        return $this;
    }



/////////////Barre de recherche (Index)
    public function getListArticlesFromRecherche($recherche)
    {
        $listArticles = [];

        // Prépare une requête de type SELECT avec un clause WHERE selon la recherche.
        $sql = 'SELECT * FROM articles WHERE publie = 1 AND (titre LIKE :recherche OR texte LIKE :recherche)';

        $req = $this->bdd->prepare($sql);
        $req->bindValue(':recherche', "%" . $recherche . "%", PDO::PARAM_STR);
        $req->execute();

        // On stock les données dans un tableau
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            // On crée des objets avec les données issus de la table.
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticles[] = $articles;
        }
        // print_r2($listArticle);
        return $listArticles;
    }








//////////////Supprimer un article (DeleteArticles) si l'article a des commentaires alors la premier requete s'effectue sinon la 2eme s'effectue 
    public function DeleteArticles(articles $articles)
    {
        $sql = 'DELETE ar , co FROM articles as ar INNER JOIN commentaires as co ON ar.id = co.id_articles WHERE ar.id = :id; DELETE FROM articles as ar WHERE ar.id = :id ';


        $req = $this->bdd->prepare($sql);
        // Sécurisation des variables
        $req->bindValue(':id', $articles->getId(), PDO::PARAM_STR);

        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            //$this->_getLastInsertId = $articles->getId();
        } else {
            $this->_result = false;
        }
        return $this;
    }




    

    /*
    public function getSearch($titre)
    {
        //prepare une requete de type select avec une clause WHERE  
        $sql = 'SELECT * FROM articles WHERE titre = :titre';
        $req = $this->bdd->prepare($sql);

        //////execution de la requete avec attribution des valeurs
        $req->bindValue(':titre', $titre, PDO::PARAM_STR); ///param init va permettre de verifier si ce qu'ont rentre comme données correspond bien a un INT sinon le programme renvoie une erreur
        $req->execute();

        /////on stocke les données obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        $articles = new articles();
        $articles->hydrate($donnees);
        ////print r2($articles);
        return $articles;
    }



*/



    /*public function add(articles $articles){
    $sql = "INSERT INTO articles" .
    "(titre,texte,publie,date)"
}*/
}
