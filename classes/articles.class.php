<?php
class articles
{

    public $id;
    public $titre;
    public $texte;
    public $date;
    public $publie;

    //////GetSetID
    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }


    /////GetSetTitre

    function getTitre()
    {
        return $this->titre;
    }

    function setTitre($titre)
    {
        $this->titre = $titre;
    }


    ////GetSetTexte

    function getTexte()
    {
        return $this->texte;
    }
    function setTexte($texte)
    {
        $this->texte = $texte;
    }

    /////GetsetDate

    function getDate()
    {
        return $this->date;
    }

    function setDate($date)
    {
        $this->date = $date;
    }


    /////getSet Publie

    function getPublie()
    {
        return $this->publie;
    }

    function setPublie($publie)
    {
        $this->publie = $publie;
    }








    public function hydrate($donnees)
    {


        /////////////////////////ID

        if (isset($donnees['id'])) {
            $this->id = $donnees['id'];
        } else {
            $this->id = '';
        }


        ///////////////TITRE

        if (isset($donnees['titre'])) {
            $this->titre = $donnees['titre'];
        } else {
            $this->titre = '';
        }


        ///////////texte

        if (isset($donnees['texte'])) {
            $this->texte = $donnees['texte'];
        } else {
            $this->texte = '';
        }

        /////////date


        if (isset($donnees['date'])) {
            $this->date = $donnees['date'];
        } else {
            $this->date = '';
        }



        ////////publie

        if (isset($donnees['publie'])) {
            $this->publie = $donnees['publie'];
        } else {
            $this->publie = 0;
        }
    }
}
