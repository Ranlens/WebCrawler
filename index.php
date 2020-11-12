<?php

//configurações de proxy SENAI

$proxy = '10.1.21.254:3128';

$arrayConfig = array(
    'http' => array(
      'proxy' => $proxy,
        'request_fulluri' => true
    ),
    'http' => array(
      'proxy' => $proxy,
        'request_fulluri' => true
    
    )
);

$context = stream_context_create($arrayConfig);
//-----------------------------------------

$url = "https://www.gutenberg.org/";
$html = file_get_contents($url, false, $context);

$dom = new DOMDocument();
libxml_use_internal_errors(true);


$dom->loadHTML($html);
libxml_clear_errors();

//Captura as tags p
$tagsDiv = $dom->getElementsByTagName('div');

//Array de paragrafo
$arrayParagrafo =  [];

foreach ($tagsDiv as $div) {
    $classe = $div->getAttribute('class');

    if ($classe == 'page_content') {
        $divInternas = $div->getElementsByTagName('div');

        foreach ($divInternas as $divInterna) {
            $classeInterna = $divInterna->getAttribute('class');
            if ($classeInterna == 'box_announce') {
                $tagsPInternas = $divInterna->getElementsByTagName('p');
                foreach ($tagsPInternas as $p) {
                    $arrayTagP[] = $p->nodeValue;
                }
            }
        }
    }
}



