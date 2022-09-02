<?php

namespace App\Entity;

use App\Db\Database;
use \PDO;


class Product
{
    /**
     * Construtor da classe
     */
    public function __construct()
    {
    }

    /**
     * Evita que a classe seja clonada
     */
    private function __clone()
    {
    }

    /**
     * Destrutor da classe - remove da memória todas as variáveis
     * definidas na classe
     */
    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
        foreach (array_keys(get_defined_vars()) as $var) {
            unset(${"$var"});
        }
        unset($var);
    }

    /**
     * Id do produto
     * @var string
     */
    private $id = "";

    /**
     * Nome do produto
     * @var string
     */
    private $nome = "";

    /**
     * Quantidade no estoque geral
     * @var int
     */
    private $estoque = "";

    /**
     * Reserva no estoque geral
     * @var string(s/n)
     */
    private $upEstoque = "";

    /**
     * Métodos get e set IdProduto
     * @param string $id
     * @return string    
     */
    public function getID()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = strval($id);
    }

    /**
     * Métodos get e set NomeProduto
     * @param string $nome
     * @return string    
     */
    public function getName()
    {
        return $this->nome;
    }
    public function setName($nome)
    {
        $this->nome = strval($nome);
    }

    /**
     * Métodos get e set Estoque
     * @param integer $estoque
     * @return string    
     */
    public function getInventory()
    {
        return $this->estoque;
    }
    public function setInventory($estoque)
    {
        $this->estoque = intval($estoque);
    }

    /**
     * Métodos get e set UpEstoque Reservado
     * @param string $upEstoque
     * @return string    
     */
    public function getReserved()
    {
        return $this->upEstoque;
    }
    public function setReserved($upEstoque)
    {
        $this->estoque = strval($upEstoque);
    }

    /**
     * Método responsável por retornar todos os produtos do BD
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getProducts($where = null, $order = null, $limit = null)
    {
        
        return (new Database('dbo.TRN699'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class); 
    }

    /**
     * Método responsável por buscar um produto com base na sua flag de reserva
     * @param string $upEstoque - $CicIndUpdE
     * @return Product
     */
    public static function getProductReserved()
    {
        return (new Database('dbo.TRN699'))->selectOnlyReserved()
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por cadastrar um produto no BD
     * @return boolean
     */
    public function cadastrar()
    {
        //INSERIR DADO NO BANCO
        $obDatabase = new Database('dbo.TRN699');
        $this->id = $obDatabase->insert([
            'field'    => $this->field,
        ]);

        //RETORNAR SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar um campo no DB
     * @return boolean
     */
    public function atualizar()
    {
        return (new Database('dbo.TRN699'))->update('CicCodERP = ' . $this->id, [
            'field'    => $this->field,
        ]);
    }

    /**
     * Método responsável por excluir o produto do DB
     * @return boolean
     */
    public function excluir()
    {
        return (new Database('dbo.TRN699'))->delete('CicCodERP = ' . $this->id);
    }
}
