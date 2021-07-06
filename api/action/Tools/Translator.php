<?php
class Translator
{
	public $langData;

	public function __construct($lang)
	{
		$sanitizedLang = "fr";

		if ($lang == "en") {
			$sanitizedLang = $lang;
		}
		require_once("./lang/" . $sanitizedLang . ".php");

		$this->langData = $langData;
		ini_set('display_errors', 1);

		$lang = file_get_contents("./lang/" . $sanitizedLang . ".json");
		$this->langData = json_decode($lang,true);
	}

	public function read($page, $node)
	{
		$value = "TEXT_NOT_FOUND";

		
		if (!empty($this->langData[$page][$node])) {
			$value = $this->langData[$page][$node];
		}

		return $value;
	}
	public function write($page,$word,$valuefr,$valueen)
	{
		$langfr = file_get_contents("./lang/fr.json");
		$langDatafr = json_decode($langfr,true);

		$langen = file_get_contents("./lang/en.json");
		$langDataen = json_decode($langen,true);

		$langDatafr[$page][$word] = $valuefr;
		$langDataen[$page][$word] = $valueen;

		file_put_contents ( "./lang/fr.json" , json_encode($langDatafr)); 
		file_put_contents ( "./lang/en.json" , json_encode($langDataen)); 
	}
}
