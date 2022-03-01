securite controller

<?php

require_once(PATH_SRC.DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR."user.models.php");

//traitement des requetes post

    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(isset($_REQUEST['action'])){
            if($_REQUEST['action']=="connexion"){
                $login=$_POST['login'];
                $password=$_POST['password'];
                connexion($login,$password);
            }
        }    
    }   

//traitement des requetes get
    if($_SERVER['REQUEST_METHOD']=="GET"){
        if(isset($_REQUEST['action'])){
            if($_REQUEST['action']=="connexion"){
                require_once(PATH_VIEWS."securite/connexion.html.php");

            }
        }    
    } 

//US1
    function connexion(string $login,string $password):void{
        $error=[];
        champ_obligatoire('login',$login,$errors,"login obligatoire");
        if(count($errors)==0){
            valid_email('login',$login,$errors);
        }
        champ_obligatoire('password',$password,$errors,"login obligatoire");
        if(count($errors)==0){
            //appel dune fonction model
            $user=find_user_login_password($login, $password);
            if(count($user)!=0){
                $_SESSION["user-connect"]=$user;
            
            }else{
                $errors['connextion']="login ou mot de passe incorrect";
                $_SESSION['errors']=$errors;
                header("location:".PATH_POST);
                exit();
             }
            
        }else{
            //erreur de validation
            $_SESSION['errors']=$errors;
            header("location:".PATH_POST);
            exit();
        }
    }