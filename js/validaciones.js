"use strict";
/*
 * Validaciones de Nexocasa (lógica pura, sin acceso al DOM).
 * Cada función devuelve "" si el valor es correcto o un mensaje de error claro.
 * No se usan expresiones regulares: se recorren los caracteres y se comprueban
 * sus códigos Unicode (los 128 primeros coinciden con ASCII).
 */
window.Nexocasa = window.Nexocasa || {};

Nexocasa.validaciones = (function () {
    // ---------- Clasificación de caracteres ----------
    const esMayuscula = c => c >= "A" && c <= "Z";
    const esMinuscula = c => c >= "a" && c <= "z";
    const esLetra = c => esMayuscula(c) || esMinuscula(c);
    const esDigito = c => c >= "0" && c <= "9";
    const esAlfanumerico = c => esLetra(c) || esDigito(c);

    const ESPECIALES_EMAIL = "!#$%&'*+-/=?^_`{|}~";

    // ---------- Utilidades ----------
    function describir(c) {
        if (c === " ") return "espacio";
        if (c === "\t") return "tabulador";
        return `«${c}»`;
    }

    // Primer carácter de texto que no cumple la condición (o null si todos la cumplen)
    function primerInvalido(texto, esValido) {
        for (const c of texto) {
            if (!esValido(c)) return c;
        }
        return null;
    }

    function contiene(texto, condicion) {
        for (const c of texto) {
            if (condicion(c)) return true;
        }
        return false;
    }

    function unirLista(elementos) {
        if (elementos.length <= 1) return elementos.join("");
        return `${elementos.slice(0, -1).join(", ")} y ${elementos[elementos.length - 1]}`;
    }

    function soloDigitos(texto) {
        return texto.length > 0 && primerInvalido(texto, esDigito) === null;
    }

    // ---------- Login ----------
    function validarNoVacio(valor, nombre) {
        if (valor.length === 0) return `Escribe ${nombre}.`;
        if (valor.trim().length === 0) {
            return `Solo has escrito espacios en blanco o tabuladores. Escribe ${nombre}.`;
        }
        return "";
    }

    // ---------- Registro ----------
    function validarUsuario(valor) {
        if (valor.length === 0) return "Escribe un nombre de usuario.";
        if (valor.length < 3 || valor.length > 15) {
            return `El nombre de usuario debe tener entre 3 y 15 caracteres (has escrito ${valor.length}).`;
        }
        if (esDigito(valor.charAt(0))) return "El nombre de usuario no puede empezar por un número.";
        const malo = primerInvalido(valor, esAlfanumerico);
        if (malo !== null) {
            return `El carácter ${describir(malo)} no está permitido: solo se admiten letras del alfabeto inglés (sin ñ ni tildes) y números.`;
        }
        return "";
    }

    function validarPassword(valor) {
        if (valor.length === 0) return "Escribe una contraseña.";
        if (valor.length < 6 || valor.length > 15) {
            return `La contraseña debe tener entre 6 y 15 caracteres (has escrito ${valor.length}).`;
        }
        const malo = primerInvalido(valor, c => esAlfanumerico(c) || c === "-" || c === "_");
        if (malo !== null) {
            return `El carácter ${describir(malo)} no está permitido: solo se admiten letras del alfabeto inglés, números, guion (-) y guion bajo (_).`;
        }
        const faltan = [];
        if (!contiene(valor, esMayuscula)) faltan.push("una letra mayúscula");
        if (!contiene(valor, esMinuscula)) faltan.push("una letra minúscula");
        if (!contiene(valor, esDigito)) faltan.push("un número");
        if (faltan.length > 0) return `La contraseña debe incluir al menos ${unirLista(faltan)}.`;
        return "";
    }

    function validarRepetirPassword(password, repetida) {
        if (repetida.length === 0) return "Repite la contraseña.";
        if (repetida !== password) return "Las contraseñas no coinciden.";
        return "";
    }

    function validarParteLocal(local) {
        if (local.length === 0) return "Falta el texto anterior a la @ (por ejemplo, nombre.apellido@dominio.es).";
        if (local.length > 64) return `La parte anterior a la @ no puede superar los 64 caracteres (tiene ${local.length}).`;
        if (local.charAt(0) === "." || local.charAt(local.length - 1) === ".") {
            return "La parte anterior a la @ no puede empezar ni terminar con un punto.";
        }
        if (local.includes("..")) return "La parte anterior a la @ no puede tener dos puntos seguidos.";
        const malo = primerInvalido(local, c => esAlfanumerico(c) || c === "." || ESPECIALES_EMAIL.includes(c));
        if (malo !== null) return `El carácter ${describir(malo)} no está permitido antes de la @.`;
        return "";
    }

    function validarSubdominio(sub) {
        if (sub.length === 0) {
            return "El dominio no puede empezar ni terminar con un punto, ni tener dos puntos seguidos.";
        }
        if (sub.length > 63) return `Cada parte del dominio (separada por puntos) admite como máximo 63 caracteres.`;
        const malo = primerInvalido(sub, c => esAlfanumerico(c) || c === "-");
        if (malo !== null) {
            return `El carácter ${describir(malo)} no está permitido en el dominio: solo letras inglesas, números, guion y punto.`;
        }
        if (sub.charAt(0) === "-" || sub.charAt(sub.length - 1) === "-") {
            return "Ninguna parte del dominio puede empezar ni terminar con un guion.";
        }
        return "";
    }

    function validarEmail(valor) {
        if (valor.length === 0) return "Escribe tu dirección de email.";
        if (valor.length > 254) return `El email no puede superar los 254 caracteres (tiene ${valor.length}).`;

        const arroba = valor.indexOf("@");
        if (arroba === -1) return "Falta la @ (por ejemplo, nombre.apellido@dominio.es).";
        if (arroba !== valor.lastIndexOf("@")) return "El email solo puede contener una @.";

        const local = valor.slice(0, arroba);
        const dominio = valor.slice(arroba + 1);

        const errorLocal = validarParteLocal(local);
        if (errorLocal) return errorLocal;

        if (dominio.length === 0) return "Falta el dominio después de la @ (por ejemplo, dominio.es).";
        if (dominio.length > 255) return "El dominio no puede superar los 255 caracteres.";
        for (const sub of dominio.split(".")) {
            const errorSub = validarSubdominio(sub);
            if (errorSub) return errorSub;
        }
        return "";
    }

    function validarSexo(valor) {
        return valor ? "" : "Selecciona una opción.";
    }

    /**
     * Fecha en formato dd/mm/aaaa, existente en el calendario y con 18 años cumplidos
     * (como muy tarde, el mismo día del registro).
     * @param {string} texto Fecha escrita por el usuario.
     * @param {Date} [hoy] Fecha de referencia (parametrizable para poder probar la función).
     */
    function validarFechaNacimiento(texto, hoy = new Date()) {
        const formato = "Escribe la fecha con el formato dd/mm/aaaa (por ejemplo, 25/03/1990).";
        if (texto.length === 0) return "Escribe tu fecha de nacimiento (dd/mm/aaaa).";

        const partes = texto.split("/");
        if (partes.length !== 3) return formato;
        const [textoDia, textoMes, textoAnio] = partes;
        const longitudesOk = textoDia.length <= 2 && textoMes.length <= 2 && textoAnio.length === 4;
        if (!soloDigitos(textoDia) || !soloDigitos(textoMes) || !soloDigitos(textoAnio) || !longitudesOk) {
            return formato;
        }

        const dia = Number(textoDia);
        const mes = Number(textoMes);
        const anio = Number(textoAnio);
        if (anio < 1900) return "El año de nacimiento no puede ser anterior a 1900.";

        // Si el día/mes no existen, Date los "corrige" (31/02 -> 03/03): se detecta comparando
        const fecha = new Date(anio, mes - 1, dia);
        if (fecha.getFullYear() !== anio || fecha.getMonth() !== mes - 1 || fecha.getDate() !== dia) {
            return `La fecha ${texto} no existe en el calendario.`;
        }
        if (fecha.getTime() > hoy.getTime()) return "La fecha de nacimiento no puede ser posterior a hoy.";

        let edad = hoy.getFullYear() - anio;
        const aunNoCumplidos = hoy.getMonth() + 1 < mes || (hoy.getMonth() + 1 === mes && hoy.getDate() < dia);
        if (aunNoCumplidos) edad--;
        if (edad < 18) return "Debes tener al menos 18 años cumplidos para registrarte.";
        return "";
    }

    return {
        validarNoVacio, validarUsuario, validarPassword, validarRepetirPassword,
        validarEmail, validarSexo, validarFechaNacimiento
    };
})();
