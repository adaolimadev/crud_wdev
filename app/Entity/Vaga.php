<?php

namespace App\Entity;

use \App\Db\Database;


class Vaga
{
    
    public $id_vaga;

    public $titulo;
    
    public $descricao;

    public $ativo; 

    public $data;

    /**
     * Método responsável por cadastrar uma nova vaga no banco
     * @return boolean
     */
    public function cadastrar()
    {
        //Definir a data
        $this->data = date('Y-m-d H:i:s');

        //Inserir a vaga no Banco
        $obDatabase = new Database('vagas');
        $this->id_vaga = $obDatabase->insert([
                                'titulo' => $this->titulo,
                                'descricao' => $this->descricao,
                                'ativo' => $this->ativo,
                                'data' => $this->data
                                ]);
        //retorna sucesso
        return true;
    }

    /**
     * Método responsável por atualizar a vaga no banco
     * @return boolean
     */
    public function atualizar()
    {
      return (new Database('vagas', '\\App\\Entity\\Vaga'))->update('id_vaga = '.$this->id_vaga,[
                                                                    'titulo' => $this->titulo,
                                                                    'descricao' => $this->descricao,
                                                                    'ativo' => $this->ativo,
                                                                    'data' => $this->data
                                                                    ]);
    }

    /**
     * Método responsável por excluir a vaga do banco
     * @return boolean
     */
    public function excluir()
    {
      return (new Database('vagas', '\\App\\Entity\\Vaga'))->delete('id_vaga= '.$this->id_vaga);
    }
    
    /**
     * Método responsável por obter as vagas do Banco de dados
     * @param  string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
     public static function getVagas($where = null, $order = null, $limit = null,$fields='*')
     {
        //return (new Database ('vagas'))->select($where,$order,$limit,$fields)->fetchAll(PDO::FETCH_CLASS,self::class);

         return (new Database('vagas', '\\App\\Entity\\Vaga'))->select($where,$order,$limit,$fields)->fetchAll();

     }

    /**
     * Método responsável por buscar uma vaga com base em seu ID
     * @param  integer $id
     * @return Vaga
     */
     public static function getVaga($id)
     {
       //return (new Database('vagas', '\\App\\Entity\\Vaga'))->select('id_vaga= '.$id)->fetchObject(self::class);
       
       return (new Database('vagas', '\\App\\Entity\\Vaga'))->select('id_vaga= '.$id)->fetchObject(self::class);
     }
     



      
}
