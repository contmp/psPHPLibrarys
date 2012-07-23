<?

	/**
	* Function to create a random password
	* 
	* A simple function to create random password, based on predefined or
	* custom charset
	* Calling function without params will result in a pin like password like
	* 90210 
	*
	* @param	int		length of desired password
	* @param	tinyint	chargroup ( 0 - 5 )
	* @param	mixed	string|array custom chars to use for creating passwd
	* @return	mixed	string|false generated password or false if failed
	*/	
	function psUtil_getPasswd($length = 5, $group = 1, $chars = false) {
	
		//> Init
		$elements	= array();
		$passwd		= '';

		//> Handle Params
		if (!is_numeric($length) || $length < 1 || $length > 2048)	$length = 5;
		if (!is_numeric($group) || $group < 0 || $group > 5)		$group = 1;

		//> fill element array as wished
		if ($group >= 1) for ($c = ord("0"); $c <= ord("9"); $c++) $elements[] = chr($c);
		if ($group >= 2) for ($c = ord("a"); $c <= ord("z"); $c++) $elements[] = chr($c);
		if ($group >= 3) for ($c = ord("A"); $c <= ord("Z"); $c++) $elements[] = chr($c);
		if ($group >= 4) $elements = array_merge($elements, str_split("!?$%&/()=?+-*"));
		if ($chars) $elements = ((is_array($chars)) ? $chars : str_split($chars, 1));

		//> Create Password now
		for ($i = 0; $i < $length; $i++) $passwd .= $elements[rand(0, count($elements) -1)];

		//> Throw Password
		return $passwd;
	}


	/**
	* Function to create a associative array from key value string or array
	* 
	* A simple function to create an associative array based on a key value
	* string (seperated by char) or array
	*
	* @param	mixed	string|array containing key value information
	* @param	char	key value seperator (like = sign in Key=Value)
	* @param	char	if sourcetype is string splitchar will create an array
	* @return	mixed	array|false generated array or false if failed
	*/	
	function psUtil_getArrayFromKeyValue($source, $sep = '=', $split = '|') {

		//> Init
		$aArray = array();
		
		//> Handle Params
		if (!is_array($source)) $source = explode($split, $source);

		//> Walk Source and create associative array
		for ($i = 0; $i < count($source); $i++)
		$aArray[substr($source[$i], 0, strpos($source[$i], $sep))] = substr($source[$i], strpos($source[$i], $sep) + 1);

		//> Return parsed array
		return $aArray;
	}


	/**
	* Funktion zum saeubern eines Strings
	*
	* @param	$String         = STRING
	*			Ausgangsname, z.B: ICH DU CACHA !/?" PENNER
	*			A - 9 wird erlaubt
	*
	* @param	$LowerCase      = BOOL
	*			Bestimmt ob der Rueckgabewert in Kleinbuchstaben erfolgen soll
	*
	* @param	$AllowedSymbols = STRING
	*			Manipulieren Sie mit dieser Zeichenkette die erlaubten Zeichen
	*
	* @return	String ICHDUCACHAPENNER
	*
	*/
	function psUtil_GetClearSting($String, $LowerCase = false, $AllowedSymbols = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789") {

		//> String saeubern
		for ($i = 0; $i < strlen($String); $i++) {
			if (strpos($AllowedSymbols, substr($String, $i, 1)) !== false) 
				$ReturnString .= substr($String, $i, 1);
		}

		//> String zurueckgebenç
		return (($LowerCase) ? strtolower($ReturnString) : $ReturnString);
	}


	/**
	* Funktion zum stripen eines Strings
	*
	* @param	$String = STRING
	*			Ausgangsname, z.B: ICH DU CACHA !/?" PENNE
	*
	* @param	$Mode = ENUM
	*			{Windows, Custom}
	*
	* @param	$FilterSymbols  = Array
	*			Beinhaltet Symbol in einem Array, die rausgefiltert werden sollen,
	*			nur aktiv im Verbund mit dem Modus "Custom"
	*
	* @return  String ICH DU CACHA ! PENNE
	*
	*/
	function psUtil_GetStripedSting($String, $Mode = "Windows", $FilterSymbols = array()) {

		//> Init
		$Not_Allowed_In_Windows = "\\/:*?\"<>|";
		$ReturnString = "";

		//> String saeubern
		switch ($Mode) {

			case "Windows":

				for ($i = 0; $i < strlen($String); $i++)
					if (strpos($Not_Allowed_In_Windows, substr($String, $i, 1)) === false)
						$ReturnString .= substr($String, $i, 1);
				break;

		};

		//> String zurueckgeben
		return $ReturnString;
	}


	/**
	* Funktion zum konvertieren einer String-Liste
	*
	* @param	$Data = STRING
	*			Enthält eine Liste als String getrennt durch einen Umbruch
	*
	* @param	$LineStart = STRING
	*			Gibt an, welche Zeichen einer neuen Zeile vorran gestellt werden sollen
	*
	* @param	$LineEnd = STRING
	*			Gibt an, welche Zeichen einer neuen Zeil angestellt werden sollen
	*
	* @param	$Sep = String
	*			Gibt an mit welchem Zeichen die einzelenn Zeilen getrennt sind
	*			Standart = \n
	*
	* @param	$IgnoreEmptry = BOOL
	*			Gibt an, ob leere Zeilen ignoriert werden sollen
	*
	* @return	String
	*			Der Rückgabewert enthält die modifizierte Liste
	*
	**/
	function psUtil_GetFormatedListe($Data, $LineStart = "- ", $LineEnd = "<br>\n", $Sep = "\n", $IgnoreEmptry = false) {

		//> Init
		$Items = explode($Sep, $Data);
		$Formated = "";

		//> Einträge durchgehen
		foreach ($Items as $Key => $Item)
			if ($IgnoreEmptry || $Item != "")
				$Formated .= $LineStart . $Item . $LineEnd;

		//> Thorw formated list
		return $Formated;

	}
	
	
	/**
	* Funktion zum erstellen eines SecDownload Links
	*
	* @param	$Data = STRING
	*			Enthält eine Liste als String getrennt durch einen Umbruch
	*
	* @return	String
	*			Gibt den kompletten SecDownloadLink zurück
	*
	**/
	function psUtil_GetSecDownloadLink($FileID) {
	
		return false;

		//> Hash Datei erzeugen
		$Time = time();
		$Hash = md5($GLOBALS["SecDown"]["Sec"].$Orig.sprintf("%08x", $Time));

		//> Get Pfad setzen
		return sprintf('http://aaa.com%s%s/%s%s', $GLOBALS["SecDown"]["Prf"], $Hash, sprintf("%08x", $Time), $Orig);
	}

