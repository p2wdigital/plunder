<?php 
namespace Tabela\Model; 
use Tabela\Model\Users;
use Plunder\ORM\ActiveRecord;
class Clientes extends ActiveRecord { 


    protected $tableName    = 'cliente';
    protected $className    = 'Cliente';
    protected $modColumns   = array();
    protected $modRelations = array();
    protected $addRelations = array();
    protected $new          = true;
    protected $saved        = null;
    protected $updated      = null;
    protected $deleted      = null;
    protected $aUser        = null;
    /** 
    * The value for the id field.
    * @var        int
    */ 
    protected $id; 

    /** 
    * The value for the razao_social field.
    * @var        string
    */ 
    protected $razao_social; 

    /** 
    * The value for the contato field.
    * @var        string
    */ 
    protected $contato; 

    /** 
    * The value for the cep field.
    * @var        string
    */ 
    protected $cep; 

    /** 
    * The value for the descricao field.
    * @var        string
    */ 
    protected $descricao; 

    /** 
    * The value for the dh_inclusao field.
    * @var        string
    */ 
    protected $dh_inclusao; 

    /** 
    * The value for the dh_alteracao field.
    * @var        string
    */ 
    protected $dh_alteracao; 

    public function getId(){ 
        return $this->id;
    }

    public function getRazaoSocial(){ 
        return $this->razao_social;
    }

    public function getContato(){ 
        return $this->contato;
    }

    public function getCep(){ 
        return $this->cep;
    }

    public function getDescricao(){ 
        return $this->descricao;
    }

    public function getDhInclusao(){ 
        return $this->dh_inclusao;
    }

    public function getDhAlteracao(){ 
        return $this->dh_alteracao;
    }

    public function getUser(){
        return $this->aUser;
    }

    public function setId($val){ 
        if($val !== null)  $val = (int) $val; 

        if($val !== $this->id):
            $this->id = $val;
            $this->modColumns[] = "id";
        endif;
    }

    public function setRazaoSocial($val){ 
        if($val !== null)  $val = (string) $val; 

        if($val !== $this->razao_social):
            $this->razao_social = $val;
            $this->modColumns[] = "razao_social";
        endif;
    }

    public function setContato($val){ 
        if($val !== null)  $val = (string) $val; 

        if($val !== $this->contato):
            $this->contato = $val;
            $this->modColumns[] = "contato";
        endif;
    }

    public function setCep($val){ 
        if($val !== null)  $val = (string) $val; 

        if($val !== $this->cep):
            $this->cep = $val;
            $this->modColumns[] = "cep";
        endif;
    }

    public function setDescricao($val){ 
        if($val !== null)  $val = (string) $val; 

        if($val !== $this->descricao):
            $this->descricao = $val;
            $this->modColumns[] = "descricao";
        endif;
    }

    public function setDhInclusao($val){ 
        if($val !== null)  $val = (string) $val; 

        if($val !== $this->dh_inclusao):
            $this->dh_inclusao = $val;
            $this->modColumns[] = "dh_inclusao";
        endif;
    }

    public function setDhAlteracao($val){ 
        if($val !== null)  $val = (string) $val; 

        if($val !== $this->dh_alteracao):
            $this->dh_alteracao = $val;
            $this->modColumns[] = "dh_alteracao";
        endif;
    }

    public function setUser(Users $val){
        $this->aUser = $val;
        $this->modRelations[] = 'User';
    }

    protected function getMapRelations($table){
        $relations = array(
            'User'=>array('cliente_id'=>'id'),
        );
        return $relations[$table];
    }


    protected function getColumnsMap(){
        return array(
            'Id'            => 'id',
            'RazaoSocial'   => 'razao_social',
            'Contato'       => 'contato',
            'Cep'           => 'cep',
            'DhInclusao'    => 'dh_inclusao',
            'DhAlteracao'   => 'dh_alteracao',
        );

    }
    protected function getAutoIncrement(){
        return array('id');
    }

}