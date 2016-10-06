<?php
include "AllegroService.php";
include "AllegroClient.php";

// Utworzenie nowego środowiska deweloperskiego
AllegroClient::$env['development'] = [
	'user' => 'UŻYTKOWNIK',
	'password' => 'HASŁO',
	'apikey' => 'KLUCZ',
];

// Utworzenie obiektu
$client = new AllegroClient;

// Pobranie informacji o użytkowniku i powitanie użytkownika
$userData = $client->doGetMyData();
echo "Witaj, ".$userData->userData->userFirstName.' '.$userData->userData->userLastName."<br>";

// Pobranie aktualnego rachunku i wyświetlenie
$billing = $client->doMyBilling();
echo "Rachunek: <strong>".$billing."</strong>";
?>
