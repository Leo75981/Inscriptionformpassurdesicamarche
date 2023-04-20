<?php   
    // Démarrage de la session 
    session_start();
    // Include de la base de données
    require_once '../config.php';

    if(!isset($_SESSION['user']))
    {
        header('Location:../index.php');
        die();
    }


    // Si les variables existent 
    if(!empty($_POST['current_pseudo']) && !empty($_POST['new_pseudo']) && !empty($_POST['new_pseudo_retype'])){
        // XSS 
        $current_pseudo = htmlspecialchars($_POST['current_pseudo']);
        $new_pseudo = htmlspecialchars($_POST['new_pseudo']);
        $new_pseudo = htmlspecialchars($_POST['new_pseudo_retype']);

        // On récupère les infos de 
        $check_pseudo  = $bdd->prepare('SELECT pseudo FROM students WHERE token = :token');
        $check_pseudo->execute(array(
            "token" => $_SESSION['user']
        ));

                // Maj
                $update = $db->prepare('UPDATE students SET pseudo = :pseudo WHERE token = :token');
                $update->execute(array(
                    "pseudo" => $new_pseudo,
                    "token" => $_SESSION['user']
                ));
                // On redirige
                header('Location: ../mon_espace.php?err=success_pseudo');
                die();
            }
        
        else{
            header('Location: ../mon_espace.php?err=current_pseudo');
            die();
        }    
    