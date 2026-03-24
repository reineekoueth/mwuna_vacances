<?php
$host = 'localhost';
$db   = 'mwuna_vacances';
$user = 'root';
$pass = '2501'; 

try {
    // Connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des données du formulaire
    $nom         = $_POST['nomdututeur'];
    $prenom      = $_POST['prenomdututeur'];
    $email       = $_POST['email'];
    $telephone   = $_POST['numteldututeur'];
    $destination = $_POST['destination'];
    $enfants     = $_POST['enfants']; // tableau d'enfants avec nom, prenom, date
    $nb_enfants  = count($enfants);

    // Mot de passe temporaire
    $mot_de_passe = password_hash('motdepasse_temp', PASSWORD_DEFAULT);

    // Appel de la procédure stockée avec OUT parameter
    $stmt = $pdo->prepare("CALL inscrire_famille(?, ?, ?, ?, ?, ?, ?, @id_tuteur)");
    $stmt->execute([$nom, $prenom, $email, $telephone, $mot_de_passe, $destination, $nb_enfants]);

    //  Récupérer l'id_tuteur généré par la procédure
    $id_tuteur = $pdo->query("SELECT @id_tuteur")->fetch(PDO::FETCH_COLUMN);

    if (!$id_tuteur) {
        throw new Exception("Impossible de récupérer l'ID du tuteur.");
    }

    //  Insérer chaque enfant dans la table 'enfant'
    $stmtEnfant = $pdo->prepare("
        INSERT INTO enfant (nom, prenom, date_naissance, id_tuteur)
        VALUES (?, ?, ?, ?)
    ");

    foreach ($enfants as $enfant) {
        $stmtEnfant->execute([
            $enfant['nom'],
            $enfant['prenom'],
            $enfant['date'],
            $id_tuteur
        ]);
    }

    header("Location: confirmation.html");
    SELECT * FROM tuteur;exit();

} catch (PDOException $e) {
    echo "Erreur PDO : " . $e->getMessage();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>