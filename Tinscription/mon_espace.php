<?php 
    session_start();
    require_once 'config.php'; // ajout connexion bdd 
 

    if(!isset($_SESSION['user'])) {
        header('Location:index.php');
        die();
    }

    // On récupere les données 
    $req = $db->prepare('SELECT * FROM students WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();
   
?>
<!doctype html>
<html lang="fr">
  <head>
    <title>Espace membre</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
     <body class="bg-dark">
        <div class="container">
            <div class="col-md-12">
                <?php 
                        if (isset($_GET['err'])){
                            $err = htmlspecialchars($_GET['err']);
                            switch ($err){
                                case 'current_password':
                                    echo "<div class='alert alert-danger'>Le mot de passe actuel est incorrect</div>";
                                break;

                                case 'success_password':
                                    echo "<div class='alert alert-success'>Le mot de passe a bien été modifié ! </div>";
                                break; 
                            }
                        }
                    ?>


                <div class="text-center">
                        <h1 class="p-5">Bonjour <?php echo $data['pseudo']; ?> !</h1>
                        <hr />
                        <a href="deconnexion.php" class="btn btn-success btn-lg">Déconnexion</a>
                        
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" id="#change_pseudo">
                          Changer mon pseudo
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg" data-toggle="modal" data-target="#change_password">
                          Changer mon mot de passe
                        </button>
                        <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#change_mail">
                          Changer mon Email
                        </button>
              
                <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#supprimer_compte">
             Supprimer mon compte (risque de poursuite judiciaire)
            </button>
            </div>
        </div>    

  
        <div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Changer mon mot de passe</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                         </div>
                            <div class="modal-body">
                                <form action="layouts/change_password.php" method="POST">
                                    <label for='current_password'>Mot de passe actuel</label>
                                    <input type="password" id="current_password" name="current_password" class="form-control" required/>
                                    <br />
                                    <label for='new_password'>Nouveau mot de passe</label>
                                    <input type="password" id="new_password" name="new_password" class="form-control" required/>
                                    <br />
                                    <label for='new_password_retype'>Re tapez le nouveau mot de passe</label>
                                    <input type="password" id="new_password_retype" name="new_password_retype" class="form-control" required/>
                                    <br />
                                    <button type="submit" class="btn btn-success">Sauvegarder</button>
                                </form>
                            </div>
                    </div>
                    </div>
                    </div>



        <div class="modal fade" id="change_mail" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Changer mon Email</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                         </div>
                            <div class="modal-body">
                                <form action="layouts/change_email.php" method="POST">
                                    <label for='current_email'>Mail actuel</label>
                                    <input type="email" id="current_email" name="current_email" class="form-control" required/>
                                    <br />
                                    <label for='new_email'>Nouveau Mail </label>
                                    <input type="email" id="new_mail" name="new_mail" class="form-control" required/>
                                    <br />
                                    <label for='new_email_retype'>Re tapez le nouveau mail</label>
                                    <input type="email" id="new_email_retype" name="new_email_retype" class="form-control" required/>
                                    <br />
                                    <button type="submit" class="btn btn-success">Sauvegarder</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




     <div class="modal fade" data-target="#change_pseudo" tabindex="0" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Changer mon Pseudo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                         </div>
                            <div class="modal-body">
                                <form action="layouts/change_pseudo.php" method="POST">
                                    <label for='current_pseudo'>Pseudo actuel</label>
                                    <input type="text" id="current_pseudo" name="current_pseudo" class="form-control" required/>
                                    <br />
                                    <label for='new_pseudo'>Nouveau Mail </label>
                                    <input type="text" id="new_pseudo" name="new_pseudo" class="form-control" required/>
                                    <br />
                                    <label for='new_pseudo_retype'>Re tapez le nouveau pseudo</label>
                                    <input type="text" id="new_pseudo_retype" name="new_pseudo_retype" class="form-control" required/>
                                    <br />
                                    <button type="submit" class="btn btn-success">Sauvegarder</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="modal fade" id="supprimer_compte" tabindex="-2" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supprimer mon compte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <form method="POST" action="supprimer.php">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</div>
                    </div>
                </div>
            </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
