<?php 
    session_start(); // session
    require_once 'config.php'; // Connexion à la db

    if(!empty($_POST['pseudo']) && !empty($_POST['password'])) //Verif des champs
    {
        // Patch XSS
        $pseudo = htmlspecialchars($_POST['pseudo']); 
        $password = htmlspecialchars($_POST['password']);
        
        
        
        // On utilise prepare contre les injections SQL 
        $check = $db->prepare('SELECT pseudo, password, token FROM students WHERE email = ?');
        $check->execute(array($pseudo));
        $data = $check->fetch();
        $row = $check->rowCount();
        
        
// A partir de la j'ai eu un peu d'aide 

        // Si > à 0 alors l'utilisateur existe
        if ($row > 0)
        {
            {
                // Si le mot de passe est le bon
                if(password_verify($password, $data['password']))
                {
                    // On créer la session et on redirige sur mon_espace.php
                    $_SESSION['user'] = $data['token'];
                    header('Location: mon_espace.php');
                    die();
                }else{ header('Location: index.php?login_err=password'); die(); }
            }else{ header('Location: index.php?login_err=pseudo'); die(); }
        }else{ header('Location: index.php?login_err=already'); die(); }
    }else{ header('Location: index.php'); die();} // si le formulaire est envoyé sans aucune données
