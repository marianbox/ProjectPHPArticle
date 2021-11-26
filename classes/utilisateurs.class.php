<?php
class utilisateurs
{

    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $mdp;
    public $sid;

    //////GetSetID
    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }


    /////GetSetnom

    function getnom()
    {
        return $this->nom;
    }

    function setnom($nom)
    {
        $this->nom = $nom;
    }


    ////GetSetprenom

    function getprenom()
    {
        return $this->prenom;
    }
    function setprenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /////Getsetemail

    function getemail()
    {
        return $this->email;
    }

    function setemail($email)
    {
        $this->email = $email;
    }


    /////getSet mdp

    function getmdp()
    {
        return $this->mdp;
    }

    function setmdp($mdp)
    {
        $this->mdp = $mdp;
    }




    //////GetSetSID
    function getsid()
    {
        return $this->sid;
    }

    function setsid($sid)
    {
        $this->sid = $sid;
    }






    public function hydrate($donnees)
    {


        /////////////////////////ID

        if (isset($donnees['id'])) {
            $this->id = $donnees['id'];
        } else {
            $this->id = '';
        }


        ///////////////NOM

        if (isset($donnees['nom'])) {
            $this->nom = $donnees['nom'];
        } else {
            $this->nom = '';
        }


        ///////////PRENOM

        if (isset($donnees['prenom'])) {
            $this->prenom = $donnees['prenom'];
        } else {
            $this->prenom = '';
        }

        /////////email


        if (isset($donnees['email'])) {
            $this->email = $donnees['email'];
        } else {
            $this->email = '';
        }



        ////////mdp

        if (isset($donnees['mdp'])) {
            $this->mdp = $donnees['mdp'];
        } else {
            $this->mdp = '';
        }

        ////////sid

        if (isset($donnees['sid'])) {
            $this->sid = $donnees['sid'];
        } else {
            $this->sid = '';
        }
    }
}
