# Obsługa serwisu Allegro
Projekt stworzony na własny użytek oraz częściowo dla firmy w której pracuję, która chciała w prosty sposób sprawdzać aktualnie wystawione aukcje oraz koszta z nimi związane.

## Konfiguracja
Aby skonfigurować środowisko należy najpierw wygenerować klucz API w ustawieniach Allegro, a następnie odpowiednio stworzyć środowisko pracy. Dostępne są dwa środowiska (deweloperskie - `development` oraz produkcyjne - `production`), dzięki którym w łatwy sposób można przełączać się między nimi w zależności od aktualnie prowadzonych prac.
```php
AllegroClient::$env['development'] = [
	'user' => 'Zbychu1986',
	'password' => '951753852',
	'apikey' => '4d8a2zc',
];
```
Ostatnia rzecz jaka pozostała to utworzenie obiektu `AllegroClient` oraz skorzystanie z dostępnych metod, które dostępne są w dokumentacji w serwisie [Allegro API](http://allegro.pl/webapi/documentation.php).
