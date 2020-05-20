/// <reference path="ajax.ts" />

window.onload = ():void => {
    MostrarEmpleados();
}; 
let ajax : Ajax = new Ajax();

function AdministrarValidaciones(): void {

    if (!ValidarCamposVacios("txtDni")) {
        AdministrarSpanError("spnDni", true);
    }
    else if (!ValidarRangoNumerico(parseInt((<HTMLInputElement>document.getElementById("txtDni")).value), parseInt((<HTMLInputElement>document.getElementById("txtDni")).min), parseInt((<HTMLInputElement>document.getElementById("txtDni")).max))) {
        AdministrarSpanError("spnDni", true);
    }
    else
    {
        AdministrarSpanError("spnDni", false);
    }

    if (!ValidarCamposVacios("txtApellido")) {
        AdministrarSpanError("spnApellido", true);
    }
    else
    {
        AdministrarSpanError("spnApellido", false);
    }

    if (!ValidarCamposVacios("txtNombre")) {
        AdministrarSpanError("spnNombre", true);
    }
    else
    {
        AdministrarSpanError("spnNombre", false);
    }

    if (!ValidarCombo((<HTMLInputElement>document.getElementById("cboSexo")).id, "---")) {
        AdministrarSpanError("spnSexo", true);
    }
    else
    {
        AdministrarSpanError("spnSexo", false);
    }

    if (!ValidarCamposVacios("txtLegajo")) {
        AdministrarSpanError("spnLegajo", true);
    }
    else if (!ValidarRangoNumerico(parseInt((<HTMLInputElement>document.getElementById("txtLegajo")).value), parseInt((<HTMLInputElement>document.getElementById("txtLegajo")).min), parseInt((<HTMLInputElement>document.getElementById("txtLegajo")).max))) {
        AdministrarSpanError("spnLegajo", true);
    }
    else
    {
        AdministrarSpanError("spnLegajo", false);
    }

    if (!ValidarCamposVacios("txtSueldo")) {
        AdministrarSpanError("spnSueldo", true);
    }
    else if (!ValidarRangoNumerico(parseInt((<HTMLInputElement>document.getElementById("txtSueldo")).value), parseInt((<HTMLInputElement>document.getElementById("txtSueldo")).min), ObtenerSueldoMaximo(ObtenerTurnoSeleccionado()))) {
        AdministrarSpanError("spnSueldo", true);
    }
    else
    {
        AdministrarSpanError("spnSueldo", false);
    }
    
     if (!ValidarCamposVacios("fileFoto")){
         AdministrarSpanError("spnFoto", true);
     }
     else
     {
         AdministrarSpanError("spnFoto", false);
     }

    if(VerificarValidacionesLogin())
    {
        AgregarEmpleado();

    }
}

function AdministrarValidacionesLogin() : void
{
    if (!ValidarCamposVacios("txtApellido")) {
        AdministrarSpanError("spnApellido", true);
    }
    else{
        AdministrarSpanError("spnApellido", false);
    }

    if (!ValidarCamposVacios("txtDni")) {
        AdministrarSpanError("spnDni", true);
    }
    else if (!ValidarRangoNumerico(parseInt((<HTMLInputElement>document.getElementById("txtDni")).value), parseInt((<HTMLInputElement>document.getElementById("txtDni")).min), parseInt((<HTMLInputElement>document.getElementById("txtDni")).max))) {
        AdministrarSpanError("spnDni", true);
    }
    else
    {
        AdministrarSpanError("spnDni", false);
    }

    if(VerificarValidacionesLogin())
    {
        (<HTMLFormElement>document.getElementById("formLogin")).submit();
    }
}

function VerificarValidacionesLogin() : boolean
{
    let validado = false;
    let spans:HTMLCollectionOf<HTMLSpanElement> = <HTMLCollectionOf<HTMLSpanElement>>document.getElementsByTagName("span");

        validado=true;
        for(let i:number = 0; i < spans.length; i++)
        {
            if((<HTMLInputElement>spans[i]).style.display == "block")
            {
                validado=false;
                break;
            }
        }

    return validado;
}

function AdministrarSpanError(nombre : string, estado : boolean) : void
{
    if (estado==true)
    {
        document.getElementById(nombre).style.display = "block";
    }
    else
    {
        document.getElementById(nombre).style.display = "none";
    }
}

function ValidarCamposVacios(idCampo : string): boolean {
    return (<HTMLInputElement>document.getElementById(idCampo)).value != "";
}

function ValidarRangoNumerico(numeroAValidar: number, min: number, max: number): boolean {
    return (numeroAValidar >= min && numeroAValidar <= max);
}

function ValidarCombo(idCmb: string, noDebeTener: string): boolean {
    return ((<HTMLInputElement>document.getElementById(idCmb)).value) != noDebeTener;
}

function ObtenerTurnoSeleccionado(): string 
{
    let chequeado:string = "";
    let inputs:NodeListOf<HTMLElement> = document.getElementsByName("rdoTurno");

    for(let i:number = 0; i < inputs.length; i++)
    {
        if((<HTMLInputElement>inputs[i]).checked)
        {
            chequeado += (<HTMLInputElement>inputs[i]).value;
            break;
        }
    }
    return chequeado;
}

/*function traerChecks() : void {
    //obtengo todos los inputs
    let checks : HTMLCollectionOf<HTMLInputElement> =  <HTMLCollectionOf<HTMLInputElement>> document.getElementsByTagName("input");
    let seleccionados : string = "";
    //recorro los inputs
    for (let index = 0; index < checks.length; index++) {
        let input = checks[index];
        
        if (input.type === "checkbox") { //verifico que sea un checkbox
            if (input.checked === true) { //verifico que este seleccionado
                seleccionados += input.name + "-";
            }
        }
    }
    //quito el ultimo guion (-)
    seleccionados = seleccionados.substr(0, seleccionados.length - 1);
    console.log(seleccionados);
}*/

function ObtenerSueldoMaximo(turnoElegido: string): number {
    let sueldoMaximo = 0;
    switch (turnoElegido) {
        case "M":
            sueldoMaximo = 20000;
            break;
        case "T":
            sueldoMaximo = 18500;
            break;
        case "N":
            sueldoMaximo = 25000;
            break;
    }
    return sueldoMaximo;
}


    
        function MostrarEmpleados():void {

            let parametros:string = `queHago=mostrarEmpleados`;

            ajax.Post("./administracion.php", 
                        MostrarSuccess, 
                        parametros, 
                        Fail);            
        }

        function AgregarEmpleado():void {

            let xhr : XMLHttpRequest = new XMLHttpRequest();
            let frm = (<HTMLFormElement>document.getElementById("formAltaEmpleado"));
            let form : FormData = new FormData(frm);

            xhr.open('POST', './administracion.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    MostrarEmpleados();
                }
            };              
        }
        
         function EliminarEmpleado(legajo:number):void {

            if(!confirm("Desea ELIMINAR el empleado "+legajo+"??")){
                return;
            }

            let parametros:string = `legajo=${legajo}`;
            
            ajax.Get("./eliminar.php", 
            DeleteSuccess, 
            parametros, 
            Fail);
            
        }
    
       function ModificarEmpleado(dni:number, apellido:string, nombre:string, sexo:string, legajo:number, sueldo:number, turno:string):void{
            (<HTMLInputElement>document.getElementById("txtDni")).value = dni.toString();
            (<HTMLInputElement>document.getElementById("txtDni")).readOnly = true;
            (<HTMLInputElement>document.getElementById("txtApellido")).value = apellido;
            (<HTMLInputElement>document.getElementById("txtNombre")).value = nombre;
            
            if(sexo == 'M'){
                (<HTMLSelectElement>document.getElementById("cboSexo")).selectedIndex = 1;
            }
            else if(sexo == 'F'){
                (<HTMLSelectElement>document.getElementById("cboSexo")).selectedIndex = 2;
            }
            
            (<HTMLInputElement>document.getElementById("txtLegajo")).value = legajo.toString();
            (<HTMLInputElement>document.getElementById("txtLegajo")).readOnly = true;
            (<HTMLInputElement>document.getElementById("txtSueldo")).value = sueldo.toString();
            
            let inputs:NodeListOf<HTMLElement> = document.getElementsByName("rdoTurno");
            for(let i:number = 0; i < inputs.length; i++){
                if((<HTMLInputElement>inputs[i]).value == turno){
                    (<HTMLInputElement>inputs[i]).checked = true;
                    break;
                }
            }
            
            (<HTMLInputElement>document.getElementById("hdnQueHago")).value = "modificarEmpleado";
            (<HTMLInputElement>document.getElementById("btnLimpiar")).disabled = true;
            (<HTMLInputElement>document.getElementById("btnEnviar")).value = "Modificar";
        }

        function MostrarSuccess(grilla:string):void {
            (<HTMLFormElement>document.getElementById("formAltaEmpleado")).reset();
            (<HTMLInputElement>document.getElementById("hdnQueHago")).value = "agregarEmpleado";
            (<HTMLInputElement>document.getElementById("btnLimpiar")).disabled = false;
            (<HTMLInputElement>document.getElementById("btnEnviar")).value = "Agregar";
            (<HTMLDivElement>document.getElementById("listaEmpleados")).innerHTML = grilla;
            (<HTMLInputElement>document.getElementById("txtLegajo")).readOnly = false;
            (<HTMLInputElement>document.getElementById("txtDni")).readOnly = false;
        }

        function DeleteSuccess(retorno:string):void {
            alert("El empleado fue eliminado");
            MostrarEmpleados();
        }
    
        function Fail(retorno:string):void {
            alert("Error" + retorno);
        }

        function mostrarPDF(dni : number){
            let parametros:string = `dni=${dni}`;
            window.open('mostrarPDF.php', '_self')
        }