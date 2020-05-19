<?php
    require_once ("../clases/empleado.php");
    $existe = false;
    $empleados = empleado::TraerTodosLosEmpleados();

    foreach($empleados as $emp){
        if($emp->_dni == $_POST["txtDni"] && $emp->_apellido == $_POST["txtApellido"]){
            $existe = true;
            break;
        }
    }
    
    if($existe){
        session_start();
        $_SESSION["DNIEmpleado"] = $emp->_dni;
        header("Location: ../index.php");
    }
    else{
        header("Location: ../login.html");
    }
?>