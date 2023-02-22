<?php

namespace app\Db;

class Pagination{

    //Numero máximo de paginas
    private $limit;

    //Quatidade total de resultados do banco
    private $results;

    //Quantidade de páginas
    private $pages;

    //Página atual
    private $currentPage;

    public function __construct($results, $currentPage = 1, $limit=10)
    {
        $this->results = $results;
        $this->limit = $limit;
        //valida se o $currentPage é maior que zero, senão for assume o valor de 1;
        $this->currentPage = (is_numeric($currentPage) and $currentPage > 0 )? $currentPage : 1;
        $this->calculate();
    }

    //Cacula a paginação em relação ao resultado dos itens
    public function calculate(){
        //Calcula o total de páginas
        $this->pages = $this->results >0 ? ceil($this->results / $this->limit): 1;

        //Verifica se a pagina atual não excede o número de páginas
        $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
    }

    //Método responsável por retornas a clausula limit da sql
    public function getLimit(){
        $offset = ($this->limit * ($this->currentPage -1));
        return $offset.','.$this->limit;
    }

    //Método responsável por retornar as opções de paginas disponível
    public function getPages(){
        //Se tiver apenas uma pagina, não retona nada
        if($this->pages ==1) return [];

        $paginas=[];
        for($i = 1;$i <= $this->pages; $i++ ){
            $paginas[]=[
                'pagina' => $i,
                'atual' => $i == $this->currentPage
            ];
        }

        return $paginas;



    }

}
