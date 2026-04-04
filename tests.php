<?php
require_once 'fonctions.php';

$tests = [];

function test($nom, $resultat, $attendu) {
    global $tests;
    $ok = $resultat === $attendu;
    $tests[] = ['nom' => $nom, 'ok' => $ok, 'attendu' => $attendu, 'obtenu' => $resultat];
}

// Tests âge
test("Age valide 12 ans",        verifierAge(date('Y-m-d', strtotime('-12 years'))), true);
test("Age trop jeune 8 ans",     verifierAge(date('Y-m-d', strtotime('-8 years'))),  false);
test("Age trop vieux 20 ans",    verifierAge(date('Y-m-d', strtotime('-20 years'))), false);
test("Age limite min 10 ans",    verifierAge(date('Y-m-d', strtotime('-10 years'))), true);
test("Age limite max 18 ans",    verifierAge(date('Y-m-d', strtotime('-18 years'))), true);

// Tests email
test("Email valide",             verifierEmail('reine@mwuna.fr'),  true);
test("Email sans arobase",       verifierEmail('reinemwuna.fr'),   false);
test("Email vide",               verifierEmail(''),                false);

// Tests nombre enfants
test("1 enfant valide",          verifierNombreEnfants(1), true);
test("5 enfants valide",         verifierNombreEnfants(5), true);
test("0 enfant invalide",        verifierNombreEnfants(0), false);
test("6 enfants invalide",       verifierNombreEnfants(6), false);

$ok = array_filter($tests, fn($t) => $t['ok']);
$ko = array_filter($tests, fn($t) => !$t['ok']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tests unitaires Mwuna</title>
  <style>
    body { font-family: Arial; max-width: 800px; margin: 40px auto; }
    h1 { font-size: 20px; }
    .resume { display:flex; gap:20px; margin:20px 0; }
    .box { padding:12px 24px; border-radius:8px; font-size:18px; font-weight:bold; }
    .ok-box { background:#d4edda; color:#155724; }
    .ko-box { background:#f8d7da; color:#721c24; }
    table { width:100%; border-collapse:collapse; }
    th { background:#f5f5f5; padding:8px 12px; text-align:left; font-size:13px; }
    td { padding:8px 12px; border-bottom:1px solid #eee; font-size:13px; }
    .pass { color:#155724; font-weight:bold; }
    .fail { color:#721c24; font-weight:bold; }
  </style>
</head>
<body>
  <h1>Tests unitaires — Mwuna Vacances</h1>
  <div class="resume">
    <div class="box ok-box"><?= count($ok) ?> / <?= count($tests) ?> tests OK</div>
    <?php if(count($ko) > 0): ?>
    <div class="box ko-box"><?= count($ko) ?> tests KO</div>
    <?php endif; ?>
  </div>
  <table>
    <tr><th>Test</th><th>Attendu</th><th>Obtenu</th><th>Resultat</th></tr>
    <?php foreach($tests as $t): ?>
    <tr>
      <td><?= $t['nom'] ?></td>
      <td><?= $t['attendu'] ? 'true' : 'false' ?></td>
      <td><?= $t['obtenu'] ? 'true' : 'false' ?></td>
      <td class="<?= $t['ok'] ? 'pass' : 'fail' ?>"><?= $t['ok'] ? 'PASS' : 'FAIL' ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>