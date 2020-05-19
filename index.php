<?php
include_once("./clases/fabrica.php");
include("./backend/validarSesion.php");
/*
if(isset($_POST["hdnDni"])){
    $inputHidden = '';
    $optionSexoSeleccionar = '<option value="---">Seleccione</option>';
    $inputRdoM = '<input type="radio" name="rdoTurno" value="Mañana"/>';
    $inputReadOnly = " readonly";
    $fabrica = new Fabrica("para modificar");
    $fabrica->traerDeArchivo("empleados");
    foreach($fabrica->getEmpleados() as $emp){
        if ($emp->getDni() == $_POST["hdnDni"]){
            $valueDni = $_POST["hdnDni"];
            $valueApellido = $emp->getApellido();
            $valueNombre = $emp->getNombre();

            if($emp->getSexo() == 'M'){
                $optionSexoMasculino = '<option value="M" selected>Masculino</option>';
            }
            else{
                $optionSexoFemenino = '<option value="F" selected>Femenino</option>';
            }

            if($emp->getTurno() == "M"){
                $inputRdoM = '<input type="radio" name="rdoTurno" value="M" checked/>';
            }
            else if ($emp->getTurno() == "T"){
                $inputRdoT = '<input type="radio" name="rdoTurno" value="T" checked/>';
            }
            else{
                $inputRdoN = '<input type="radio" name="rdoTurno" value="N" checked/>';
            }

            $valueLegajo = $emp->getLegajo();
            $valueSueldo = $emp->getSueldo();
            break;
        }
    }
}*/
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="./javascript/funciones.js"></script>
        <link rel="icon" type="image/png" href="./img/icon.png" />
        <title>Formulario Alta Empleados</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./css/estiloIndex.css">
    </head>
    <body>
    <a style="text-align:right;" href="./backend/cerrarSesion.php">Cerrar sesion</a>

    <div class="container">

        <div style="width:400px">

            <table>
            <tr>
            <td>
            <form id="formAltaEmpleado" enctype="multipart/form-data" method="POST" action="administracion.php">
            <h2>Alta de Empleados</h2>
            <table align="center">
                <tr>
                    <td colspan="2"><h4>Datos Personales</h4></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>
                <tr>
                    <td>DNI: </td>
                    <td><input type="number" name="txtDni" id="txtDni" min="1000000" max="55000000" placeholder="♥♥♥♥♥♥♥♥"/>
                        <span id="spnDni" style="display:none"> *</span></td>
                </tr>
                <tr>
                    <td>Apellido/s: </td>
                    <td><input type="text" name="txtApellido" id="txtApellido" placeholder="Bieber"/>
                        <span id="spnApellido" style="display:none"> *</span></td>
                </tr>
                <tr>
                    <td>Nombre/s: </td>
                    <td><input type="text" name="txtNombre" id="txtNombre" placeholder="Justin"/>
                        <span id="spnNombre" style="display:none"> *</span></td>
                </tr>
                <tr>
                    <td>Sexo: </td>
                    <td>
                        <select name="cboSexo" id="cboSexo">
                            <option value="---" selected>Seleccione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                        <span id="spnSexo" style="display:none"> *</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><h4>Datos Laborales</h4></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>
                <tr>
                    <td>Legajo: </td>
                    <td><input type="number" name="txtLegajo" id="txtLegajo" min="100" max="550" placeholder="♥♥♥"/>
                        <span id="spnLegajo" style="display:none"> *</span></td>
                </tr>
                <tr>
                    <td>Sueldo: </td>
                    <td><input type="number" name="txtSueldo" id="txtSueldo" min="8000" step="500" placeholder="♥♥♥♥♥"/>
                        <span id="spnSueldo" style="display:none"> *</span></td>
                </tr>
                <tr>
                    <td>Turno: </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="radio" name="rdoTurno" value="M" checked/>
                        Mañana
                    </td>
                </tr>
                <tr>
                    <td></td>
                     <td>
                         <input type="radio" name="rdoTurno" value="T"/>
                        Tarde
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="radio" name="rdoTurno" value="N"/>
                        Noche
                    </td>
                </tr>
                <tr>
                <td>Foto:</td>
                <td> <input type="file" name="fileFoto" id="fileFoto"/>
                    <span id="spnFoto" style="display:none"> *</span></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <input type="reset" name="btnLimpiar" id="btnLimpiar" value="Limpiar" /> 
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                    <input type="button" name="btnEnviar" id="btnEnviar" value="Agregar" onclick="AdministrarValidaciones()"/>

                    <input type="hidden" name="queHago" id="hdnQueHago" value="agregarEmpleado"/>

                    </td>
                </tr>
                </table>
            </form>
            </td>
            </div>
            <td>
            </td>
            <td>
                <div style="width:1000px" id=listaEmpleados>
                </div>
            </td>
            </tr>
        </div>

    </body>
</html>
