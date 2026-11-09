"use strict";
/* Página de registro: validación del formulario de nuevo usuario */
document.addEventListener("DOMContentLoaded", () => {
    const V = Nexocasa.validaciones;
    const valor = id => document.getElementById(id).value;

    function sexoSeleccionado() {
        const marcado = document.querySelector('input[name="sexo"]:checked');
        return marcado ? marcado.value : "";
    }

    Nexocasa.interfaz.configurarFormulario(document.getElementById("formulario-registro"), [
        {
            id: "usuario",
            etiqueta: "Nombre de usuario",
            validar: () => V.validarUsuario(valor("usuario"))
        },
        {
            id: "password",
            etiqueta: "Contraseña",
            validar: () => V.validarPassword(valor("password")),
            revalidar: ["repetir-password"]
        },
        {
            id: "repetir-password",
            etiqueta: "Repetir contraseña",
            validar: () => V.validarRepetirPassword(valor("password"), valor("repetir-password"))
        },
        {
            id: "email",
            etiqueta: "Dirección de email",
            validar: () => V.validarEmail(valor("email"))
        },
        {
            id: "grupo-sexo",
            etiqueta: "Sexo",
            validar: () => V.validarSexo(sexoSeleccionado())
        },
        {
            id: "fecha-nacimiento",
            etiqueta: "Fecha de nacimiento",
            validar: () => V.validarFechaNacimiento(valor("fecha-nacimiento"))
        }
    ]);
});
