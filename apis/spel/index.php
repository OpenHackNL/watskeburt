<?php

$apiLink = "https://watskeburt-jgroenen-1.c9.io/apis/vragen/";
$filename = "huidigevraag.json";

/*
 * 1. POST vraag. master
 * 	Haal round op
 * 	Gooi oude weg
 * 	Haal nieuwe vraag op
 * 	Sla gegevens op
 * 		Vraag
 * 		Antwoord
 * 		Locked
 * 		Roundnummer
 * 		Antwoorden
 * 			ID
 * 			Antwoord
 * 	RETURN 
 * 		Vraag
 * 		antwoord
 * 
 * 2. POST vraag. slave
 * 	Zit id in?
 * 	niet locked?
 * 	Sla antwoord van client op of overschrijf de gegevens
 * 
 * 3. GET vraag. master
 * 	Lock invoer (API 2)
 * RETURN
 * 	Geef json file terug.
 * 		Vraag
 * 		Antwoord
 * 		Spelers:
 * 			ID
 * 			Antwoord
 */
 
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
 
//make file if not exist
touch($filename);

$data = json_decode(file_get_contents("php://input"));
 
//1 of 2
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	//2
	if(!empty($data->id)){
		//oude file ophalen
		$myJson = json_decode(file_get_contents($filename));
		
		//locked? stoppen
		if($myJson->locked)
			exit();
		
		//updaten/erinzetten
		$myJson->answers->{$data->id} = $data->answer;
		
		//file opslaan
		file_put_contents($filename, json_encode($myJson));
		
		//exit
		exit();
	}
	//1
	else{
		//oude file ophalen
		$myJson = json_decode(file_get_contents($filename));
		
		//ronde erbij tellen
		if(isset($myJson->round))
			$myJson->round++;
		else 
			$myJson->round = 1;
		
		//nieuwe vraag ophalen
		$gegevens = json_decode(file_get_contents($apiLink));
		
		//verder vullen
		$gegevens->round = $myJson->round;
		$gegevens->answers = (Object) [];
		$gegevens->locked = false;
		
		//opslaan en overshcrijven
		file_put_contents($filename, json_encode($gegevens));
		
		//opsturen
		echo(json_encode($gegevens));
		
		//exit
		exit();
	}
}
//3: Sluit de vraag en controleer de antwoorden (aan de client kant)
else{
	//file ophalen
	$myJson = json_decode(file_get_contents($filename));
	//set locked
	$myJson->locked = true;
	//sla nieuwe json op
	file_put_contents($filename, json_encode($myJson));
	//stuur json op
	echo(json_encode($myJson));
}