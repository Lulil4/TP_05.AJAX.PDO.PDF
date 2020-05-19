<?php 

abstract class Persona
{
    public $_apellido;
    public $_dni;
    public $_nombre;
    public $_sexo;

    public function __construct($nombre = null, $apellido = null, $dni = null, $sexo = null)
    {
        if($dni !=null && $nombre!=null && $apellido!=null && $sexo!=null){
        $this->_nombre = $nombre;
        $this->_apellido = $apellido;
        $this->_dni = $dni;
        $this->_sexo = $sexo;
        }
    }

    public function getApellido()
    {
        return $this->_apellido;
    }

    public function getDni() 
    {
        return $this->_dni;
    }

    public function getNombre()
    {
        return $this->_nombre;
    }

    public function getSexo()
    {
        return $this->_sexo;
    }

    public abstract function hablar($idioma);

    public function toString()
    {
        return $this->_dni . " - " . $this->_nombre .  " - " . $this->_apellido . " - " . $this->_sexo;
    }
}