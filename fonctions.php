<?php
// fonctions.php

function verifierAge(string $dateNaissance): bool {
    $date = new DateTime($dateNaissance);
    $age = $date->diff(new DateTime())->y;
    return $age >= 10 && $age <= 18;
}

function verifierEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function verifierNombreEnfants(int $nb): bool {
    return $nb >= 1 && $nb <= 5;
}
?>