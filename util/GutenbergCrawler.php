<?php

class GutenbergCrawler {
    
    private $url;
    private $proxy;
    private $dom;
    private $html;
    
     
    public function __construct() {
        // Seta os valores das variaveis
        $this->url = "http://gutenberg.org";
        $this->proxy = "10.1.21.254.3128";
        $this->dom = new DOMDocument();
        
        
       
    }
    public function getParagrafos(){
        $this->carregarHtml();
        $tagsDiv = $this->capturarTagsDivGeral();
        $divsInternas = $this->capturarDivsInternaPageContent($tagsDiv);
        $tagsP = $this->capturarTagsP($divsInternas);
        $arrayPagrafos = $this->getArrayParagrafos($tagsP);
        return $arrayPagrafos;
        
    }

    private function getContextoConexao(){
        $arrayConfig = array (
            'http' => array(
                'proxy' => $this->proxy,
                'request_fulluri' => true
            ),
            'http' => array (
                'proxy' => $this->proxy,
                'request_fulluri' => true
            )
        );
        $context = stream_context_create($arrayConfig);
        return $context;
        
    }
    
    private function carregarHtml(){
        $context = $this->getContextoConexao();
        $this->html = file_get_contents($this->url, false, $context);
        
        libxml_clear_errors(true);
        
        //Tranforma o html em objeto
        $this->dom->loadHTML($this->html);
        libxml_clear_errors();
        
        
    }
    private function capturaTagsDivGeral(){
        $tagsDiv = $this->dom->getElementsByTagName('div');
        return $tagsDiv;
    }
       
    private function capturaDivsInternasPageContent($divsGeral){
        $divsInternas = null;
        foreach ($divsGeral as $div){
           $class = $div->getAttribute('class');
           
           if ($class == 'page-content'){
               $divsInternas = $div->getElementsByTagName('div');
               break;
           }
        }
        return $divsInternas;
    }
    private function capturaTagsP($divInterna){
        $tagsP = null;
        foreach ($divInterna as $divInterna){
            $classeInterna = $divInterna->getAttribute('class');
            if($classeInterna == 'box_annouce'){
                $tagsP = $divInterna->getElementsByTagName('p');
                
                
            }
    }
    return $tagsP;
 }
    private function getArrayParagrafos($tagsPInternas) {
           $arrayTagP = [];

        foreach ($tagsPInternas as $p) {
            $arrayTagP[] = $p->nodeValue;
        }
        return $arrayTagP;
    }
}

