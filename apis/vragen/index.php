<?php

$url = "https://nl.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&explaintext=&titles=30_juni&exsectionformat=plain";

$raw = file_get_contents($url);

$json = json_decode($raw);

$page = reset($json->query->pages);

$lines = explode("\n", $page->extract);

$questions = [];

$eventType = "";

foreach ($lines as $line) {
    if (in_array($line, ["Geboren", "Overleden"])) {
        $eventType = $line;
    } else if ($line === "") {
        
    }
    if (preg_match("/^[0-9]{4} -/", $line)) {
        $question = $line;
        if ($eventType) {
            $question .= ", " . strtolower($eventType);
        }
        $questions[] = $question;
    }
}

$question = $questions[array_rand($questions)];

list($year, $question) = explode(" - ", $question);

echo json_encode([
    "year" => $year,
    "event" => $question
]);