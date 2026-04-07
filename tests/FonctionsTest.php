<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../fonctions.php'; // inclut ton fichier de fonctions

class FonctionsTest extends TestCase
{
    public function testVerifierAge()
    {
        $this->assertTrue(verifierAge('2014-01-01')); // 10 ans+
        $this->assertFalse(verifierAge('2000-01-01')); // trop vieux
        $this->assertFalse(verifierAge('2020-01-01')); // trop jeune
    }

  public function testVerifierEmail()
{
    // Emails valides
    $this->assertTrue(verifierEmail('test@example.com'));
    $this->assertTrue(verifierEmail('prenom.nom@exemple.co'));
    $this->assertTrue(verifierEmail('user+tag@sub.domain.org'));

    // Emails invalides
    $this->assertFalse(verifierEmail('test@@example.com'));   // double @
    $this->assertFalse(verifierEmail('test.com'));             // pas de @
    $this->assertFalse(verifierEmail('user@.com'));            // domaine invalide
    $this->assertFalse(verifierEmail('user@domain..com'));     // double point
    $this->assertFalse(verifierEmail('user@domain,com'));      // virgule au lieu de point
}

    public function testVerifierNombreEnfants()
    {
        $this->assertTrue(verifierNombreEnfants(3));
        $this->assertFalse(verifierNombreEnfants(0));
        $this->assertFalse(verifierNombreEnfants(6));
    }
}