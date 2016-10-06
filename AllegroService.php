<?php
/**
 * Opis:	Warstwa abstrakcji, dzięki której możliwe jest zalogowanie się do Allegro.
 * 			Dzięki protokołowi Soap możliwe jest zdalne wykonywanie metod Web API.
 *
 * Autor:	Piotr Filipek
 * Email:	piotrek290@gmail.com 
 */

abstract class AllegroService {
	// Domyślny adres WSDL
	private $wsdl = 'https://webapi.allegro.pl/service.php?wsdl';

	// Zwracany obiekt sesji
	private $session = null;

	// Domyślna konfiguracja
	protected $config = [
		'country' => 1
	];

	// Klucz sesji oraz uchwyt do obiektu Soap
	protected $sessionKey, $client;


	/**
	 * Uruchomienie konstruktora spowoduje utworzenie obiektu Soap,
	 * a także rozszerzenie tablicy z konfiguracją o dodatkowe pola (dane do logowania).
	 *
	 * @param Array $config - konfiguracja użytkownika
	 * @return AllegroService Object
	 */
	public function __construct($config){
		$this->client = new SoapClient($this->wsdl);
		$this->config = $this->extend($config, $this->config);
	}


	/**
	 * Metoda odpowiedzialna jest za logowanie się do serwisu,
	 * a także za zapisanie klucza sesji do zmiennej.
	 *
	 * @return Null
	 */
	protected function doLogin(){
		try {
			// Pobranie klucza wersji potrzebnego do zalogowania się
			$version = (array)($this->client->doQuerySysStatus(array(
				'sysvar' => 1,
				'countryId' => $this->config['country'],
				'webapiKey' => $this->config['apikey']
			)));

			// Próba zalogowania się
			$this->session = $this->client->doLogin(array(
				'userLogin' => $this->config['user'],
				'userPassword' => $this->config['password'],
				'countryCode' => $this->config['country'],
				'webapiKey' => $this->config['apikey'],
				'localVersion' => $version['verKey']
			));

			// Zapisanie sesji do zmiennej aby była widoczna globalnie w aplikacji
			$this->sessionKey = (string) json_decode(json_encode($this->session), true)['sessionHandlePart'];
		} catch(Exception $message){
			// W przypadku wystąpienia błędu podczas logowania
			echo "Internal error: ".$message;
		}
	}


	/**
	 * Metoda pomocnicza, dzięki której można w łatwy sposób rozszerzyć tablicę o kolejną.
	 *
	 * @param Array $array1 - tablica o którą ma być rozszerzona druga tablica
	 * @param Array $array2 - tablica, która jest rozszerzana
	 * @param Array
	 */
	protected function extend($array1, $array2){
		foreach($array1 as $key => $item){
			$array2[$key] = $item;
		}

		return $array2;
	}
}
?>
