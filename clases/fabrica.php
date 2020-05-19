<?php 
require_once ("clases/empleado.php");
require_once ("clases/interfaces.php");
class Fabrica
{
    private $_cantidadMaxima;
    private $_empleados;
    private $_razonSocial;

    public function __construct(string $razonSocial)
    {
        $this->_razonSocial = $razonSocial;
        $this->_empleados = array();
        $this->_cantidadMaxima = 7;
    }

    public function getEmpleados(){
        return $this->_empleados;
    }
    public function agregarEmpleado(Empleado $emp)
    {
        $seAgrego = false;
        $repeated = false;

        if (count($this->_empleados) < $this->_cantidadMaxima)
        {
            foreach($this->_empleados as $empLoop)
            {
                if ($empLoop == $emp)
                {
                    $repeated = true;
                    $this->eliminarEmpleadosRepetidos();
                    break;
                }
            }
        
            if($repeated == false)
            {
                array_push($this->_empleados, $emp);
                $seAgrego = true;
            }
        }

        return $seAgrego;
    }

    public function calcularSueldos()
    {
        $totalSueldos = 0;

        foreach($this->_empleados as $empleado)
        {
            $totalSueldos += $empleado->getSueldo();
        }
        return $totalSueldos;
    }

    public function eliminarEmpleado(Empleado $emp)
    {
        $i = 0;
        $seElimino = false;
        foreach($this->_empleados as $empDentro)
        {
            if ($empDentro == $emp)
            {
                unlink($emp->GetPathFoto());
                unset($this->_empleados[$i]);
                array_values($this->_empleados);
                $seElimino = true;
                break;
            }
            $i++;
        }
        return $seElimino;
    }

    private function eliminarEmpleadosRepetidos()
    {
        $this->_empleados = array_unique($this->_empleados, SORT_REGULAR);
        array_values($this->_empleados);
    }

    public function toString()
    {
        $fabrica = "";
        $fabrica .= $this->_cantidadMaxima . " - " . $this->_razonSocial . "<br>";
        foreach ($this->_empleados as $emp)
        {
            $fabrica .= $emp->toString() . "<br>";
        }
        return $fabrica;
    }

    public function traerDeArchivo($nombreArchivo)
    {
        $path = "./archivos/" . $nombreArchivo . ".txt";
        $fArchivo = fopen($path, "r");

        while(!feof($fArchivo)){
            $arrEmp = explode(" - ", fgets($fArchivo));
            $arrEmp[0] = trim($arrEmp[0]); 

            if($arrEmp[0] != ""){

                $arrEmp[7] = trim($arrEmp[7]);

                $this->AgregarEmpleado(new Empleado($arrEmp[0], $arrEmp[1], $arrEmp[2], $arrEmp[3], $arrEmp[4], $arrEmp[5], $arrEmp[6], $arrEmp[7]));
            }
        }
        fclose($fArchivo);
    }

    public function guardarEnArchivo($nombreArchivo)
    {
        $path = "./archivos/" . $nombreArchivo . ".txt";
        $fArchivo = fopen($path, "w");

        foreach($this->_empleados as $emp)
        {
            fwrite($fArchivo, $emp->toString() . "\r\n");
        }
		fclose($fArchivo);
    }
}