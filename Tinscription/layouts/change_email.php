<?php   
   // En bonus, on peut modifier son mot de passe 
   
   
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
    if(!empty($_POST['current_email']) && !empty($_POST['new_email']) && !empty($_POST['new_email_retype'])){
        // XSS 
        $current_email = htmlspecialchars($_POST['current_email']);
        $new_email = htmlspecialchars($_POST['new_email']);
        $new_email_retype = htmlspecialchars($_POST['new_email_retype']);

        // On récupère les infos 
        $check_email  = $bdd->prepare('SELECT email FROM students WHERE token = :token');
        $check_email->execute(array(
            "token" => $_SESSION['user']
        ));
        $data_email = $check_email->fetch();

        // Si le mot de passe est le bon
        if(email_verify($current_email, $data_email['email']))
        {
            // Si le mot de passe tapé est bon
            if($new_email === $new_email_retype){
          
                // On met à jour la table 
                $update = $db->prepare('UPDATE students SET email = :email WHERE token = :token');
                $update->execute(array(
                    "email" => $new_email,
                    "token" => $_SESSION['user']
                ));
                // On redirige
                header('Location: ../mon_espace.php?err=success_email');
                die();
            }
        }
        else{
            header('Location: ../mon_espace.php?err=current_email');
            die();
        }

    }
    else{
        header('Location: ../mon_espace.php');
        die();
    }



