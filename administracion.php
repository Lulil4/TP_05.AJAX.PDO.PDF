 <?php
include("./backend/validarSesion.php");
require_once ("./clases/empleado.php");
require_once ("./clases/AccesoDatos.php");

$queHago = isset($_POST['queHago']) ? $_POST['queHago'] : NULL;

switch($queHago){
    case "mostrarEmpleados":
    $empleados = empleado::TraerTodosLosEmpleados();
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

    foreach($empleados as $emp){
        echo"<tr>
        <td>" . $emp->toString() . "</td>
        <td><img width='90' height='90' src='./" . $emp->getPathFoto() . "'/></td>
        <td><input type='button' onclick='EliminarEmpleado(".$emp->GetLegajo().")' value='Eliminar'></td>
        <td><input type='button' name='btnModificar' id='btnModificar' value='Modificar' onclick='ModificarEmpleado(".$emp->GetDni().",
        `".$emp->GetApellido()."`, `".$emp->GetNombre()."`, `".$emp->GetSexo()."`,
        ".$emp->GetLegajo().", ".$emp->GetSueldo().", `".$emp->GetTurno()."`)'/></td>
       </tr>";
    }
    echo"
    <tr>
    <form id=formModificar name=formModificar method='POST' action='../index.php'>
    <input type='hidden' name='hdnDni' id='hdnDni' />
    </form>
    </tr>
    <tr>
    <td colspan='4' align='center'><input type='button' value='Ver empleados en formato PDF' onclick = 'mostrarPDF(".$_SESSION["DNIEmpleado"].")'></td>
    </table>"
    ;
    break;
    case "agregarEmpleado":
    case "modificarEmpleado":
        $destino = "fotos/" . $_FILES["fileFoto"]["name"];
        $seCargaraLaFoto = true;
        $tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);
        $destino = "fotos/" . $_POST["txtDni"] . "-" . $_POST["txtApellido"] . "." . $tipoArchivo;

        $emp = new Empleado($_POST["txtDni"], $_POST["txtNombre"], $_POST["txtApellido"], $_POST["cboSexo"], $_POST["txtLegajo"], $_POST["txtSueldo"],  $_POST["rdoTurno"], $destino);
       
        if($queHago == "modificarEmpleado"){
            $empleados = empleado::TraerTodosLosEmpleados();

            if($_FILES["fileFoto"]["size"] > 1 * 1024 * 1024 ){
                $seCargaraLaFoto = false;
            }
            else if(getimagesize($_FILES["fileFoto"]["tmp_name"]) == false){
                $seCargaraLaFoto = false;
            }
            else if($tipoArchivo != "jpg" && $tipoArchivo != "bmp" && $tipoArchivo != "gif" && $tipoArchivo != "png" && $tipoArchivo != "jpeg"){
                $seCargaraLaFoto = false;
            }

            if ($seCargaraLaFoto){
                foreach($empleados as $oldEmp){
                    if ($oldEmp->_legajo == $_POST["txtLegajo"]){
                        unlink($oldEmp->_pathFoto);
                        break;
                    }
                }
                Empleado::ModificarEmpleado($emp);
                move_uploaded_file($_FILES["fileFoto"]["tmp_name"], $destino);
            }
        }
        else if($seCargaraLaFoto && !file_exists($destino) ){

            $emp->GuardarEmpleado();
            move_uploaded_file($_FILES["fileFoto"]["tmp_name"], $destino);
        }
        break;
    default:
        echo"Error";
}

?>