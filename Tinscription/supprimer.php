<?php
ini_set('display_errors', 1);
error_reporting(E_ALL); 
// Inclure la connexion de base de données
include "config.php";

session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    $id = $_SESSION['user'];

    // Préparer la requête de suppression en fonction de l'identifiant de l'utilisateur
    $query = "DELETE FROM students WHERE id=$id";

    // Exécuter la requête pour supprimer l'enregistrement
    if ($db->query($query)) {
        // Si la suppression réussit, déconnecter l'utilisateur et le rediriger vers la page de connexion
        unset($_SESSION['user']);
        header('Location: index.php');
    } else {
        // Si la suppression échoue, afficher un message d'erreur
        echo "Désolé, une erreur s'est produite lors de la suppression de votre compte. Il semblerait que votre crédit social ne soit pas assez élevé.";
    }
} else {
    // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
    header('Location: index.php');
}

?>