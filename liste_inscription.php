<?php
// 🔹 Connexion à la base de données
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "mwuna_vacances";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// 🔹 Suppression d’une inscription (si le bouton a été cliqué)
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Sécurisation : conversion en entier

    $stmt = $conn->prepare("DELETE FROM inscriptions WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Inscription supprimée avec succès !'); window.location='liste_inscriptions.php';</script>";
    } else {
        echo "<script>alert('❌ Erreur lors de la suppression');</script>";
    }

    $stmt->close();
}

// 🔹 Récupération de toutes les inscriptions
$sql = "SELECT * FROM inscriptions ORDER BY date_inscription DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des inscriptions - Mwuna Vacances</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('image/emoji.jpg') center/cover no-repeat fixed;
      color: white;
      text-align: center;
      padding: 40px;
    }

    h1 {
      color: #FFD700;
      margin-bottom: 30px;
    }

    table {
      width: 95%;
      margin: auto;
      border-collapse: collapse;
      background: rgba(255,255,255,0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 10px 12px;
      border: 1px solid rgba(255,255,255,0.2);
      text-align: center;
    }

    th {
      background: #FFD700;
      color: black;
    }

    tr:nth-child(even) {
      background: rgba(255,255,255,0.05);
    }

    tr:hover {
      background: rgba(255,255,255,0.2);
    }

    a.btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 18px;
      border-radius: 8px;
      border: 2px solid #FFD700;
      background: rgba(255,255,255,0.1);
      color: #FFD700;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    a.btn:hover {
      background: #FFD700;
      color: black;
      transform: scale(1.05);
    }

    .delete-btn {
      background: #ff4d4d;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 6px 12px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .delete-btn:hover {
      background: #e60000;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

  <h1>Liste des inscriptions</h1>

  <?php if ($result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Date de naissance</th>
          <th>Nom du tuteur</th>
          <th>Prénom du tuteur</th>
          <th>Téléphone du tuteur</th>
          <th>Email</th>
          <th>Destination</th>
          <th>Date d’inscription</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nom']) ?></td>
            <td><?= htmlspecialchars($row['prenom']) ?></td>
            <td><?= htmlspecialchars($row['date_naissance']) ?></td>
            <td><?= htmlspecialchars($row['nom_tuteur']) ?></td>
            <td><?= htmlspecialchars($row['prenom_tuteur']) ?></td>
            <td><?= htmlspecialchars($row['num_tel_tuteur']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= ucfirst($row['destination']) ?></td>
            <td><?= $row['date_inscription'] ?></td>
            <td>
              <button class="delete-btn" onclick="confirmerSuppression(<?= $row['id'] ?>)">Supprimer</button>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Aucune inscription enregistrée pour le moment.</p>
  <?php endif; ?>

  <a href="index.html" class="btn">⬅ Retour à l'accueil</a>

  <script>
    function confirmerSuppression(id) {
      if (confirm("⚠️ Voulez-vous vraiment supprimer cette inscription ?")) {
        window.location.href = "liste_inscriptions.php?delete=" + id;
      }
    }
  </script>

</body>
</html>

<?php
$conn->close();
?>
