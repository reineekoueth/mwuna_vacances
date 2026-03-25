<?php 
$host = 'localhost';
$db   = 'mwuna_vacances';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $sejours = $pdo->query("SELECT * FROM sejour")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}

// Images par défaut pour certaines destinations
$images = [
    'congo'   => 'image/brz.jpg',
    'senegal' => 'image/senegal.jpg',
    'angola'  => 'image/angola.jpg',
    'gabon'   => 'image/gabon.jpg',
];

// Descriptions par défaut
$descriptions = [
    'congo'   => "Pointe-Noire, c'est l'endroit où l'océan Atlantique caresse la forêt équatoriale...",
    'senegal' => "Le Sénégal t'accueille avec ses sourires, sa musique et son soleil éternel...",
    'angola'  => "L'Angola, c'est l'Afrique brute : plages infinies, savanes dorées, chutes d'eau...",
    'gabon'   => "Forêts primaires, gorilles, lagons turquoise et parcs nationaux incroyables...",
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mwuna Vacances - Choix Destination</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="page-destination">

<header>
  <div class="logo">
    <a href="index.html">
      <img src="image/logo-removebg-preview.png" alt="Logo" />
    </a>
  </div>
  <nav>
    <ul>
      <li><a href="index.html">Accueil</a></li>
      <li><a href="description.html">À propos</a></li>
      <li><a href="contact.html">Contact</a></li>
    </ul>
  </nav>
</header>

<div class="titre">
  <h1>Prêt pour l'aventure de ta vie ?</h1>
</div>

<div class="bouton">
  <a href="inscription.html" class="btn">Je m'inscris !</a>
</div>

<!-- SECTION CHOIX DYNAMIQUE -->
<section class="choice">
  <?php if (!empty($sejours)): ?>
    <?php foreach ($sejours as $sejour): 
        $key = strtolower($sejour['pays']); 
        $img = $images[$key] ?? 'image/default.jpg'; 
        $desc = $descriptions[$key] ?? $sejour['description'] ?? "Description indisponible."; 
    ?>
      <div>
        <img 
          src="<?= htmlspecialchars($img) ?>" 
          alt="Séjour au <?= htmlspecialchars($sejour['pays']) ?>" 
          class="logo-destination"
        />
        <h4><?= strtoupper(htmlspecialchars($sejour['pays'])) ?></h4>
        <p><?= htmlspecialchars($desc) ?></p>
        
        <!-- Places disponibles -->
        <p class="places">👥 Places disponibles : <?= htmlspecialchars($sejour['places_dispo']) ?></p>
        
        <!-- Âge recommandé -->
        <p class="age">🧒 Âge : <?= htmlspecialchars($sejour['age_min']) ?> à <?= htmlspecialchars($sejour['age_max']) ?> ans</p>
        
        <!-- Date de départ -->
        <p class="date">🗓️ Départ : <?= date('d/m/Y', strtotime($sejour['date_depart'])) ?></p>
        
        <a href="inscription.html" class="clique">Choisir la destination</a>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Aucune destination disponible pour le moment.</p>
  <?php endif; ?>
</section>

<!-- COMPTE À REBOURS -->
<div class="countdown-container">
  ⏳ Clôture des inscriptions dans : <span id="countdown"></span>
</div>

<footer>
  &copy; 2025 Mwuna Vacances.
</footer>

<script>
const countdownElement = document.getElementById("countdown");
const endDate = new Date("0000-00-00T00:00:00").getTime();

function updateCountdown() {
  const now = new Date().getTime();
  const distance = endDate - now;

  if (distance <= 0) {
    countdownElement.innerHTML = "🚫 Inscriptions terminées !";
    return;
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  countdownElement.innerHTML = `${days}j ${hours}h ${minutes}m ${seconds}s`;
}

setInterval(updateCountdown, 1000);
updateCountdown();
</script>

</body>
</html>
