<?php

  namespace Hcode;

  class Model {

    private $values = [];

    public function __call($name, $args) // args é o valor que foi passado do atributo.
    {
 
        $method = substr($name, 0, 3); // qual os três primeiros digitos do nome do método que foi chamado.
        $fieldName = substr($name, 3, strlen($name)); //qual o nome do campo que foi chamado
 
        switch ($method)
        {
            case "get":
                return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;
                break;
 
            case "set":
                $this->values[$fieldName] = $args[0];
                break;
        }
 
    }
    

    /*public function __call($name, $args) // Método Mágico recebe nome e argumentos. Args é o valor do atributo
    {
      $method = substr($name, 0, 3); // a partir da posição 0 traga 1 e traga 2 
      $fieldName = substr($name, 3, strlen($name)); // strlen conta todos e vai a partir da terceira posição até o final.
    
      switch ($method)
      {
        case "get":
          return $this->values[$fieldName];
        break;
        case "set":
          $this->values[$fieldName] = $args[0];
        break;
        
      }
    }*/

    public function setData($data = array())
    {

      foreach ($data as $key => $value) {
        $this->{"set".$key}($value); //tudo que for dinâmico dentro do PHP tem que estar entre chaves
      
      }

    }

    public function getValues()
    {

      return $this->values;
   
    }


  }

?>