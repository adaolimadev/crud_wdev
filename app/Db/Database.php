<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database{

    //Credencias do BD
    const HOST = "db";
    const NAME = "meubd";
    const USER = "meuuser";
    const PASS = "minhasenha";

    private $table;

    private $connection;

    private $entity;

    /**Método construtor da classe de conexão com BD 
     * Pede-se a tabela e a classe a ser objetificada
     * @param string $table
     * @param string $entity
     * 
    */   
    public function __construct($table = null, $entity=null)
    {
        $this->table = $table;
        $this->entity = $entity;
        $this->setConnection();
    }
    
    //Cria a conexão com o banco de dados usando as credenciais do BD
    private function setConnection()
    {
        try
         {
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $e) 
        {
            die('ERROR: ' . $e->getMessage());
        }
    }

    /**
     * Método responsável por executar queries dentro do banco de dados
     * @param string $querie
     * @param array $params (opcional)
     * @return PDOStatement
     */
    public function execute ($query, $params = [])
    {
        try 
        {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        }
        catch(PDOException $e)
        {
            die('ERROR: ' . $e->getMessage());
        }
    }

    /**
     * Metodo responsável po inserir valores no Banco de Dados
     * @param array $valores [campo =>valor]
     * @return integer ID Inserido
     */
    public function insert($valores)
    {
        try
        {
        //Define os campos
        $campos = array_keys($valores);

        //Faz a contagem dos campos associando a um array $bind
        $binds = array_pad([], count($campos), '?');

        //Cria o insert com os campos e valores passado pelo parametro $valores
        $query = 'INSERT INTO ' . $this->table. ' ('.implode(',',$campos).') values ('.implode(',',$binds).')';

        //Executa o insert
        $this-> execute($query,array_values($valores));

        //retorna o ultimo ID inserido
        return $this->connection->lastInsertId();

        }
        catch(PDOException $e) 
        {
            die('Erro ao Cadastrar:  ' . $e->getMessage());
        }
    }

     /**
     * Método responsável por obter as vagas do Banco de dados
     * @param  string $where
     * @param string $order
     * @param string $limit
     * @return PDOStatement
     */
     public function select($where=null, $order=null, $limit=null, $fields='*')
     {
         //Verifica se os parametros não são nulos
         $where = !empty($where) ? 'WHERE '.$where : '';
         $order = !empty($order) ? 'ORDER BY '.$order : '';
         $limit = !empty($limit) ? 'LIMIT '.$limit : '';
         
        //Monta a query
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;
        
        //Executa a query
        $st = $this->execute($query);
        $st->setFetchMode( PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->entity );

        return $st;
     } 

     /**
     * Método responsável por executar atualizações no banco de dados
     * @param  string $where
     * @param  array $values [ field => value ]
     * @return boolean
     */
     public function update($where, $values)
     {  
        //Obtem os dados da query
        $fields = array_keys($values);

        //Monta a query
        $query = 'UPDATE '.$this->table. ' SET '.implode('=?, ',$fields).'=? WHERE '.$where. ';';
        
        //Executa a query
        $this->execute($query, array_values($values));

        return true;
     }

     /**
     * Método responsável por excluir dados do banco
     * @param  string $where
     * @return boolean
     */
    public function delete($where)
    {
       //Monta a query
       $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

       //Executa a query
       $this->execute($query);

       return true;
    }
}

?>