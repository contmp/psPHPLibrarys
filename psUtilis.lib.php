<?

	/**
	* Zufaelliges Password erzeugenasdasdasd
	*
	* @param	Length = INT
	*			Anzahl der Zeichen fuer das Password
	*
	* @param	pKomplexitaet = INT
	*			Komplexitaetsgrad des Passwords
	*				0 - Benutzerdefiniert
	*				1 - nur Kleinbuchstaben
	*				2 - auch Grossbuchstaben
	*				3 - Zahlen auch noch
	*				4 - Sonderzeichen
	*
	* @param	pZeichen = STRING
	*			Zeichen die verwendet werden sollen (String)
	*
	* @return	STRINT
	*			Zufaelliges Password
	*
	*/
	function psUtil_CreatePassword($Length, $pKomplexitaet, $pZeichen) {

		//> Init
		$lZeichen  = array();
		$lPassword = "";

		//> Generate Char Array
		if ($pKomplexitaet >= 1) for ($c = ord("0"); $c <= ord("9"); $c++) $lZeichen[] = chr($c);
		if ($pKomplexitaet >= 2) for ($c = ord("a"); $c <= ord("z"); $c++) $lZeichen[] = chr($c);
		if ($pKomplexitaet >= 3) for ($c = ord("A"); $c <= ord("Z"); $c++) $lZeichen[] = chr($c);
		if ($pKomplexitaet >= 4) array_push($lZeichen, "!", "?", "$", "%", "&", "/", "(", ")", "=", "?", "+", "-", "*", "\\");

		//> Ggfl. nur eigene Zeichen verwenden
		if ($pKomplexitaet == 0) $lZeichen = $pZeichen;

		//> Passwort erstellen
		for ($i = 0; $i < $Length; $i++) $lPassword .= $lZeichen[rand(0, count($lZeichen) -1)];

		//> Throw Password
		return $lPassword;
	}


	/**
	* Erstellt ein Assoziatives Array aus einem Daten Array in der Form:
	*
	*   1 => Name1=Bastian
	*   2 => Name2=Anna
	*   3 => Name3=Gert
	* Zu
	*   Name1 => Bastian
	*   Name2 => Anna
	*   Name3 => Gert
	*
	* @param	$SourceArray   = ARRAY
	*			Dieser Parameter beinhaltet die Ursprungsarray
	*
	* @param	$ItemSeperator = STRING
	*			Gibt an, durch welchen String die Datensaetze getrennt werden
	*
	* @return	ARRAY
	*/
	function psUtil_KeyValueToArray($SourceArray, $Seperator = "=") {

		//> Init
		$ReturnArray = array();

		for ($i = 0; $i < count($SourceArray); $i++) {
			$ReturnArray[substr($SourceArray[$i], 0, strpos($SourceArray[$i], $Seperator))] =
				substr($SourceArray[$i], strpos($SourceArray[$i], $Seperator) + 1, strlen($SourceArray[$i]) - strpos($SourceArray[$i], $Seperator) + 1);
		}

		//> Return parsed array
		return $ReturnArray;
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
	

