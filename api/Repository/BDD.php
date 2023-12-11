<?php
if ($_SESSION['role'] == 5)
{
	$dbRequest = 'SELECT IDuser, idavatar, nom, prenom, inscription, role, theme, num_telephone, newsletter FROM UTILISATEUR WHERE email= :email AND password= :password';
}


//var_dump($_SESSION);

$result = $db->prepare($dbRequest);

$result->execute([
	'email' => $_SESSION['email'],
	'password' => hash('sha256', $_SESSION['pwd'])
]);

$reponse = $result->fetch();

if ($reponse == false)
{
	$msg = 'Impossible de se connecter à la base de donnee';
	header('location: Accueil.php?message=' . $msg);
	exit();
}

$IDuser = $reponse['IDuser'];


?>