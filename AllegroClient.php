<?php
/**
 * Opis:	Warstwa opakowująca klase AllegroService, w której znajdują się
 * 			gotowe rozwiązania ułatwiające obsługę serwisu Allegro.
 *
 * Autor:	Piotr Filipek
 * Email:	piotrek290@gmail.com 
 */

class AllegroClient extends AllegroService {
	const DEVELOPMENT = 'development';
	const PRODUCTION = 'production';

	// Konfiguracja środowisk pracy
	public static $env = [
		'development' => [],
		'production' => []
	];


	/**
	 * Konstruktor w którym defuniujemy typ środowiska.
	 * Po wyborze środowiska pracy następuje proces logowania do serwisu.
	 *
	 * @return AllegroClient Object
	 */
	public function __construct($env_type = self::DEVELOPMENT){
		parent::__construct(self::$env[$env_type]);
		$this->doLogin();
	}


	/**
	 * Sprawdza aktualny rachunek Allegro (kwota do zapłaty)
	 *
	 * @return String
	 */
	public function doMyBilling(){
		return $this->client->doMyBilling([
			'sessionHandle' => $this->sessionKey
		])->myBilling;
	}

	/**
	 * Automatyczne uruchomienie metody z podanymi argumentami
	 * 
	 * @param String $name - nazwa metody, która nie została zdefiniowana w ciele klasy
	 * @param Array $arguments - lista przyjmowanych argumentów
	 * @return Mixed
	 */
	public function __call($name, $arguments){
		if(isset($arguments[0])) $arguments = (array)$arguments[0];
		else $arguments = array();

		// Domyślnie używane wartości przy każdej próbe wywołania metody
		$arguments['sessionId'] = $this->sessionKey;
		$arguments['sessionHandle'] = $this->sessionKey;
		$arguments['sessionHandlePart'] = $this->sessionKey;
		$arguments['webapiKey'] = $this->config['apikey'];
		$arguments['countryId'] = $this->config['country'];
		$arguments['countryCode'] = $this->config['country'];

		//echo "Calling <i>$name</i> method...<br>";

		// Wywołanie metody z argumentami 
		return $this->client->__soapCall($name, array($arguments));
	}
}
?>
