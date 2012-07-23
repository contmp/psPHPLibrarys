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
	
		//> init
		$elements	= array();
		$passwd		= '';

		//> handle Params
		if (!is_numeric($length) || $length < 1 || $length > 2048)	$length = 5;
		if (!is_numeric($group) || $group < 0 || $group > 5)		$group = 1;

		//> fill element array as wished
		if ($group >= 1) for ($c = ord("0"); $c <= ord("9"); $c++) $elements[] = chr($c);
		if ($group >= 2) for ($c = ord("a"); $c <= ord("z"); $c++) $elements[] = chr($c);
		if ($group >= 3) for ($c = ord("A"); $c <= ord("Z"); $c++) $elements[] = chr($c);
		if ($group >= 4) $elements = array_merge($elements, str_split("!?$%&/()=?+-*"));
		if ($chars) $elements = ((is_array($chars)) ? $chars : str_split($chars, 1));

		//> create password
		for ($i = 0; $i < $length; $i++) $passwd .= $elements[rand(0, count($elements) -1)];

		//> throw password
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

		//> init
		$aArray = array();
		
		//> handle params
		if (!is_array($source)) $source = explode($split, $source);

		//> walk source and create associative array
		for ($i = 0; $i < count($source); $i++)
		$aArray[substr($source[$i], 0, strpos($source[$i], $sep))] = substr($source[$i], strpos($source[$i], $sep) + 1);

		//> throw created array
		return $aArray;
	}


	/**
	* Function to filter out unwanted chars for local file system
	* 
	* A simple function to filter unsouported chars from a string
	* which allows you to verify if input if compatible
	*
	* @param	string	containing wanted filename
	* @param	enum	os selecting default = win other : mac
	* @return	string	cleared filename
	*/	
	function psUtil_getValidFilename($filename, $os = "Win") {

		//> init
		$Not_Allowed_In_Mac		= "/:";
		$Not_Allowed_In_Windows	= "\\/:*?\"<>|";

		//> clear  filename
		switch ($os) {
		
			case 'Mac':
				for ($i = 0; $i < strlen($Not_Allowed_In_Mac); $i++)
					$filename = str_replace(substr($Not_Allowed_In_Mac, $i, 1), '', $filename);
				break;

			default:
			case "Win":
				for ($i = 0; $i < strlen($Not_Allowed_In_Windows); $i++)
					$filename = str_replace(substr($Not_Allowed_In_Windows, $i, 1), '', $filename);
				break;

		};

		//> throw cleaned filename
		return $filename;
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
