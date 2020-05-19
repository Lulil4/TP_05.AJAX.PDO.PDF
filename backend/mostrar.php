<?php
include("./backend/validarSesion.php");

require_once ("./clases/empleado.php");
$fEmpleados = fopen("./archivos/empleados.txt", "r");
echo "

       
        <table align='center' border='1'>
        <tr>
        <td colspan='4'><h2>Listado de Empleados</h2> </td>
       </tr>
        <tr>
            <td colspan='4'><h4>Info</h4></td>
        </tr>
        <tr>
        <td colspan='4'><hr></td>
        </tr>";
while (!feof($fEmpleados)) {
    $arrEmp = array();
    $arrEmp = explode(" - ", fgets($fEmpleados));
    $arrEmp[0] = trim($arrEmp[0]);
    if ($arrEmp[0] != "")
    {
        $emp = new Empleado($arrEmp[0],
        $arrEmp[1], $arrEmp[2], $arrEmp[3], $arrEmp[4],
        $arrEmp[5], $arrEmp[6], $arrEmp[7]);

        echo"<tr>
         <td>" . $emp->toString() . "</td>
         <td><img width='90' height='90' src='./" . $emp->getPathFoto() . "'/></td>
         <td><input type='button' onclick='EliminarEmpleado(".$emp->GetLegajo().")' value='Eliminar'></td>
         <td><input type='button' name='btnModificar' id='btnModificar' value='Modificar' onclick='ModificarEmpleado(".$emp->GetDni().",
         `".$emp->GetApellido()."`, `".$emp->GetNombre()."`, `".$emp->GetSexo()."`,
         ".$emp->GetLegajo().", ".$emp->GetSueldo().", `".$emp->GetTurno()."`)'/></td>
        </tr>";
    }
 }
    fclose($fEmpleados);
    echo"
    <tr>
    <td><form id=formModificar name=formModificar method='POST' action='../index.php'>
    <input type='hidden' name='hdnDni' id='hdnDni' /></td>
    </form>
    </tr>
    <tr><td>Ver en formato PDF</td></tr>
    </table>"
    ;

?>