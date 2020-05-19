<?php
    include("./backend/validarSesion.php");
    include("./clases/empleado.php");
    $empleados = empleado::TraerTodosLosEmpleados();

    foreach($empleados as $emp){
        if($emp->_legajo == $_GET["legajo"]){
            $empleado = $emp;
            break;
        }
    }

    Empleado::EliminarEmpleado($emp);
?>