<?php
// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "", "students");

// Vérifier la connexion
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}

// Requête SQL
$sql = "SELECT * FROM students";

// Exécution de la requête
$result = mysqli_query($conn, $sql);

// Vérifier si la requête a réussi
if (!$result) {
    die("Erreur de requête: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Liste des Données</title>
</head>
<body>
	<div style="width: 500px; margin: 20px auto;">
		<a href="inscription.php">Ajouter une nouvelle donnée</a>
		<table width="100%" cellpadding="5" cellspacing="1" border="1">
			<tr>
				<td>Pseudo</td>
				<td>Email</td>
			</tr>
			<?php while ($row = mysqli_fetch_array($result)) { ?>
			<tr>
				<td><?php echo $row['pseudo']; ?></td>
				<td><?php echo $row['email']; ?></td>
				<td>
					<a href="update.php?id=<?php echo $row['id']; ?>">Editer</a> | 
					<a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Etes-vous sûr?');">Supprimer</a>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
</body>
</html>

