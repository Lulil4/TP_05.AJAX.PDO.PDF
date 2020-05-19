var Ajax = /** @class */ (function () {
    function Ajax() {
        var _this = this;
        this.Get = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            var parametros = params.length > 0 ? params : "";
            ruta = params.length > 0 ? ruta + "?" + parametros : ruta;
            _this._xhr.open('GET', ruta);
            _this._xhr.send();
            _this._xhr.onreadystatechange = function () {
                if (_this._xhr.readyState === Ajax.DONE) {
                    if (_this._xhr.status === Ajax.OK) {
                        success(_this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this._xhr.status);
                        }
                    }
                }
            };
        };
        this.Post = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            var parametros = params.length > 0 ? params : "";
            _this._xhr.open('POST', ruta, true);
            _this._xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            _this._xhr.send(parametros);
            _this._xhr.onreadystatechange = function () {
                if (_this._xhr.readyState === Ajax.DONE) {
                    if (_this._xhr.status === Ajax.OK) {
                        success(_this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this._xhr.status);
                        }
                    }
                }
            };
        };
        this._xhr = new XMLHttpRequest();
        Ajax.DONE = 4;
        Ajax.OK = 200;
    }
    return Ajax;
}());
/// <reference path="ajax.ts" />
window.onload = function () {
    MostrarEmpleados();
};
var ajax = new Ajax();
function AdministrarValidaciones() {
    if (!ValidarCamposVacios("txtDni")) {
        AdministrarSpanError("spnDni", true);
    }
    else if (!ValidarRangoNumerico(parseInt(document.getElementById("txtDni").value), parseInt(document.getElementById("txtDni").min), parseInt(document.getElementById("txtDni").max))) {
        AdministrarSpanError("spnDni", true);
    }
    else {
        AdministrarSpanError("spnDni", false);
    }
    if (!ValidarCamposVacios("txtApellido")) {
        AdministrarSpanError("spnApellido", true);
    }
    else {
        AdministrarSpanError("spnApellido", false);
    }
    if (!ValidarCamposVacios("txtNombre")) {
        AdministrarSpanError("spnNombre", true);
    }
    else {
        AdministrarSpanError("spnNombre", false);
    }
    if (!ValidarCombo(document.getElementById("cboSexo").id, "---")) {
        AdministrarSpanError("spnSexo", true);
    }
    else {
        AdministrarSpanError("spnSexo", false);
    }
    if (!ValidarCamposVacios("txtLegajo")) {
        AdministrarSpanError("spnLegajo", true);
    }
    else if (!ValidarRangoNumerico(parseInt(document.getElementById("txtLegajo").value), parseInt(document.getElementById("txtLegajo").min), parseInt(document.getElementById("txtLegajo").max))) {
        AdministrarSpanError("spnLegajo", true);
    }
    else {
        AdministrarSpanError("spnLegajo", false);
    }
    if (!ValidarCamposVacios("txtSueldo")) {
        AdministrarSpanError("spnSueldo", true);
    }
    else if (!ValidarRangoNumerico(parseInt(document.getElementById("txtSueldo").value), parseInt(document.getElementById("txtSueldo").min), ObtenerSueldoMaximo(ObtenerTurnoSeleccionado()))) {
        AdministrarSpanError("spnSueldo", true);
    }
    else {
        AdministrarSpanError("spnSueldo", false);
    }
    if (!ValidarCamposVacios("fileFoto")) {
        AdministrarSpanError("spnFoto", true);
    }
    else {
        AdministrarSpanError("spnFoto", false);
    }
    if (VerificarValidacionesLogin()) {
        AgregarEmpleado();
    }
}
function AdministrarValidacionesLogin() {
    if (!ValidarCamposVacios("txtApellido")) {
        AdministrarSpanError("spnApellido", true);
    }
    else {
        AdministrarSpanError("spnApellido", false);
    }
    if (!ValidarCamposVacios("txtDni")) {
        AdministrarSpanError("spnDni", true);
    }
    else if (!ValidarRangoNumerico(parseInt(document.getElementById("txtDni").value), parseInt(document.getElementById("txtDni").min), parseInt(document.getElementById("txtDni").max))) {
        AdministrarSpanError("spnDni", true);
    }
    else {
        AdministrarSpanError("spnDni", false);
    }
    if (VerificarValidacionesLogin()) {
        document.getElementById("formLogin").submit();
    }
}
function VerificarValidacionesLogin() {
    var validado = false;
    var spans = document.getElementsByTagName("span");
    validado = true;
    for (var i = 0; i < spans.length; i++) {
        if (spans[i].style.display == "block") {
            validado = false;
            break;
        }
    }
    return validado;
}
function AdministrarSpanError(nombre, estado) {
    if (estado == true) {
        document.getElementById(nombre).style.display = "block";
    }
    else {
        document.getElementById(nombre).style.display = "none";
    }
}
function ValidarCamposVacios(idCampo) {
    return document.getElementById(idCampo).value != "";
}
function ValidarRangoNumerico(numeroAValidar, min, max) {
    return (numeroAValidar >= min && numeroAValidar <= max);
}
function ValidarCombo(idCmb, noDebeTener) {
    return (document.getElementById(idCmb).value) != noDebeTener;
}
function ObtenerTurnoSeleccionado() {
    var chequeado = "";
    var inputs = document.getElementsByName("rdoTurno");
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].checked) {
            chequeado += inputs[i].value;
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
function ObtenerSueldoMaximo(turnoElegido) {
    var sueldoMaximo = 0;
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
function MostrarEmpleados() {
    var parametros = "queHago=mostrarEmpleados";
    ajax.Post("./administracion.php", MostrarSuccess, parametros, Fail);
}
function AgregarEmpleado() {
    var xhr = new XMLHttpRequest();
    var frm = document.getElementById("formAltaEmpleado");
    var form = new FormData(frm);
    xhr.open('POST', './administracion.php', true);
    xhr.setRequestHeader("enctype", "multipart/form-data");
    xhr.send(form);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            MostrarEmpleados();
        }
    };
}
function EliminarEmpleado(legajo) {
    if (!confirm("Desea ELIMINAR el empleado " + legajo + "??")) {
        return;
    }
    var parametros = "legajo=" + legajo;
    ajax.Get("./eliminar.php", DeleteSuccess, parametros, Fail);
}
function ModificarEmpleado(dni, apellido, nombre, sexo, legajo, sueldo, turno) {
    document.getElementById("txtDni").value = dni.toString();
    document.getElementById("txtDni").readOnly = true;
    document.getElementById("txtApellido").value = apellido;
    document.getElementById("txtNombre").value = nombre;
    if (sexo == 'M') {
        document.getElementById("cboSexo").selectedIndex = 1;
    }
    else if (sexo == 'F') {
        document.getElementById("cboSexo").selectedIndex = 2;
    }
    document.getElementById("txtLegajo").value = legajo.toString();
    document.getElementById("txtLegajo").readOnly = true;
    document.getElementById("txtSueldo").value = sueldo.toString();
    var inputs = document.getElementsByName("rdoTurno");
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].value == turno) {
            inputs[i].checked = true;
            break;
        }
    }
    document.getElementById("hdnQueHago").value = "modificarEmpleado";
    document.getElementById("btnLimpiar").disabled = true;
    document.getElementById("btnEnviar").value = "Modificar";
}
function MostrarSuccess(grilla) {
    document.getElementById("formAltaEmpleado").reset();
    document.getElementById("hdnQueHago").value = "agregarEmpleado";
    document.getElementById("btnLimpiar").disabled = false;
    document.getElementById("btnEnviar").value = "Agregar";
    document.getElementById("listaEmpleados").innerHTML = grilla;
    document.getElementById("txtLegajo").readOnly = false;
    document.getElementById("txtDni").readOnly = false;
}
function DeleteSuccess(retorno) {
    alert("El empleado fue eliminado");
    MostrarEmpleados();
}
function Fail(retorno) {
    alert("Error" + retorno);
}
function mostrarPDF(dni) {
    var parametros = "dni=" + dni;
    window.open('mostrarPDF.php', '_newtab');
}
