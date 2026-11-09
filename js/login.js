"use strict";
/* Página principal: validación del formulario de acceso de usuarios registrados */
document.addEventListener("DOMContentLoaded", () => {
    const V = Nexocasa.validaciones;
    const valor = id => document.getElementById(id).value;

    Nexocasa.interfaz.configurarFormulario(document.getElementById("formulario-login"), [
        {
            id: "usuario-login",
            etiqueta: "Nombre de usuario",
            validar: () => V.validarNoVacio(valor("usuario-login"), "tu nombre de usuario")
        },
        {
            id: "password-login",
            etiqueta: "Contraseña",
            validar: () => V.validarNoVacio(valor("password-login"), "tu contraseña")
        }
    ]);
});
