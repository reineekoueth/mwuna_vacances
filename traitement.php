<?php
$host = 'localhost';
$db   = 'mwuna_vacances';
$user = 'root';
$pass = '2501'; 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des données du formulaire
    $nom         = $_POST['nomdututeur'];
    $prenom      = $_POST['prenomdututeur'];
    $email       = $_POST['email'];
    $telephone   = $_POST['numteldututeur'];
    $destination = $_POST['destination'];
    $enfants     = $_POST['enfants'];
    $nb_enfants  = count($enfants);

    $mot_de_passe = password_hash('motdepasse_temp', PASSWORD_DEFAULT);

    // Appel de la procédure stockée (crée tuteur + réservation)
    $stmt = $pdo->prepare("CALL inscrire_famille(?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $email, $telephone, $mot_de_passe, $destination, $nb_enfants]);

    // Récupérer l'id du tuteur créé
    $id_tuteur = $pdo->lastInsertId();

    // Insérer chaque enfant
    $stmtEnfant = $pdo->prepare("INSERT INTO enfant (nom, prenom, date_naissance, id_tuteur) VALUES (?, ?, ?, ?)");

    foreach ($enfants as $enfant) {
        $stmtEnfant->execute([
            $enfant['nom'],
            $enfant['prenom'],
            $enfant['date'],
            $id_tuteur
        ]);
    }

    echo "Inscription réussie !";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>