<?php
include("./backend/validarSesion.php");
require_once __DIR__ . '/vendor/autoload.php';
require_once './clases/empleado.php';
$dni = isset($_SESSION["DNIEmpleado"]) ? $_SESSION["DNIEmpleado"] : NULL;

$myPDF = new \Mpdf\Mpdf(['orientation' => 'P', 
'pagenumPrefix' => 'Página nro. ',
'pagenumSuffix' => ' - ',
'nbpgPrefix' => ' de ',
'nbpgSuffix' => ' páginas']);

$empleados = empleado::TraerTodosLosEmpleados();
$empleadosHtml = "
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
     $empleadosHtml .= 
        "<tr>
            <td>" . $emp->toString() . "</td>
            <td><img width='90' height='90' src='./" . $emp->getPathFoto() . "'/></td>
        </tr>";
    }

$empleadosHtml .= "</table>";

    //Encabezado (apellido y nombre del alumno y número de página)
$myPDF->SetHeader("Morel, Melany Lucia||Página nº{nbpg}");
    //Cuerpo (Título, listado, con su respectiva foto y sin los botones)
$myPDF->WriteHTML($empleadosHtml);
    //Pie de página (url del sitio web)
$myPDF->SetFooter("{DATE j-m-Y}||CAMBIAR***************************LinkHeroku");
    //El archivo .pdf contendrá clave, la misma será el número de D.N.I. del usuario logueado.
$myPDF->SetProtection(array('copy', 'print'), $dni, "admin");
    //muestro
$myPDF->Output("empleados.pdf", "I");
    
    