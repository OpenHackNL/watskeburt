<?php

$day = date("j");
$month = [
    1 => "januari",
    "februari",
    "maart",
    "april",
    "mei",
    "juni",
    "juli",
    "augustus",
    "september",
    "oktober",
    "november",
    "december"
][date("n")];

$url = "https://nl.wikipedia.org/w/api.php?format=json&action=query" .
       "&prop=extracts&explaintext=&titles={$day}_{$month}&exsectionformat=wiki";

$raw = file_get_contents($url);

$json = json_decode($raw);

$page = reset($json->query->pages);

$lines = explode("\n", $page->extract);

$events = [];

$eventType = "";

foreach ($lines as $line) {
    if (preg_match("/^== [a-zA-Z]* ==$/", $line)) {
        $eventType = trim(str_replace("==", "", $line));
    } else if (preg_match("/^[0-9]{4} -/", $line)) {
        $events[] = $line . " - " . $eventType;
    }
}

$event = $events[array_rand($events)];

list($year, $event, $eventType) = explode(" - ", $event);

echo json_encode([
    "date" => $day . " " . $month,
    "year" => $year,
    "event" => $event,
    "eventType" => $eventType,
]);