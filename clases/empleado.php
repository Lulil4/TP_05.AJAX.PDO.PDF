<?php 
require_once ("persona.php");
require_once ("AccesoDatos.php");
class Empleado extends Persona
{
    public $_legajo;
    public $_sueldo;
    public $_turno;
    public $_pathFoto;

    public function __construct($dni = null, $nombre = null, $apellido = null, $sexo = null, $legajo = null, $sueldo = null, $turno = null, $pathFoto = null)
    {
        parent::__construct($nombre, $apellido, $dni, $sexo);
        if($legajo!=null && $sueldo!=null && $turno!=null && $pathFoto!=null){
        $this->_legajo = $legajo;
        $this->_sueldo = $sueldo;
        $this->_turno = $turno;
        $this->_pathFoto = $pathFoto;
        }
    }
    
    public function getPathFoto()
    {
        return $this->_pathFoto;
    }

    public function getLegajo()
    {
        return $this->_legajo;
    }

    public function getSueldo()
    {
        return $this->_sueldo;
    }
    
    public function getTurno()
    {
        return $this->_turno;
    }
    
    public function hablar($idioma)
    {
        $idiomas = "";
        foreach($idioma as $unIdioma)
        {
            $idiomas .= $unIdioma . ", ";
        }
        $idiomas = rtrim($idiomas, ", ");
        return $idiomas;
    }

    public function toString()
    {
        return parent::toString() . " - " . $this->_legajo . " - " . $this->_sueldo . " - " . $this->_turno . " - " . $this->_pathFoto;
    }

    public static function TraerTodosLosEmpleados()
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT dni AS _dni, nombre AS _nombre, apellido AS _apellido, sexo AS _sexo, legajo AS _legajo, sueldo AS _sueldo, turno AS _turno, pathFoto AS _pathFoto FROM empleado");        
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_INTO, new Empleado);
        
        return $consulta;
    }

    
    public function GuardarEmpleado()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleado VALUES(:dni, :nombre, :apellido, :sexo, :legajo, :sueldo, :turno, :pathFoto)");
        $consulta->bindValue(':dni', $this->_dni, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->_nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->_apellido, PDO::PARAM_STR);
        $consulta->bindValue(':sexo', $this->_sexo, PDO::PARAM_STR);
        $consulta->bindValue(':legajo', $this->_legajo, PDO::PARAM_INT);
        $consulta->bindValue(':sueldo', $this->_sueldo, PDO::PARAM_INT);
        $consulta->bindValue(':turno', $this->_turno, PDO::PARAM_STR);
        $consulta->bindValue(':pathFoto', $this->_pathFoto, PDO::PARAM_STR);

        $res = $consulta->execute();   
        $res .= "asd";
    }
    
    public static function ModificarEmpleado($emp)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleado SET dni = :dni, nombre = :nombre, apellido = :apellido, sexo = :sexo, legajo = :legajo, sueldo = :sueldo, turno = :turno, pathFoto = :pathFoto WHERE legajo = :legajo");
        $consulta->bindValue(':dni', $emp->_dni, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $emp->_nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $emp->_apellido, PDO::PARAM_STR);
        $consulta->bindValue(':sexo', $emp->_sexo, PDO::PARAM_STR);
        $consulta->bindValue(':legajo', $emp->_legajo, PDO::PARAM_INT);
        $consulta->bindValue(':sueldo', $emp->_sueldo, PDO::PARAM_INT);
        $consulta->bindValue(':turno', $emp->_turno, PDO::PARAM_STR);
        $consulta->bindValue(':pathFoto', $emp->_pathFoto, PDO::PARAM_STR);

        return $consulta->execute();
    }

    public static function EliminarEmpleado($emp)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM empleado WHERE legajo = :legajo");
        unlink($emp->GetPathFoto());
        $consulta->bindValue(':legajo', $emp->_legajo, PDO::PARAM_INT);
        return $consulta->execute();

    }
}