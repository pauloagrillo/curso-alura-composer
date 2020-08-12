<?php

namespace CursoAlura\BuscadorDeCursos;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private $httpClient;
    private $crawler;
    
    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
        
        $resposta = $this->httpClient->request('GET', $url);
        $html = $resposta->getBody();
       
        $this->crawler->addHtmlContent($html);

        $elemenotsCursos = $this->crawler-> filter('.card-curso__nome');
        $cursos = [];

        foreach ($elemenotsCursos as $elemento) {
            $cursos[] = $elemento->textContent . PHP_EOL;
        }
        return $cursos;
    }
}
