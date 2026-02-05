const fs = require('fs');

exports.handleFileAppend = (req, res) => {
    try {
        // LEER SIEMPRE EL ARCHIVO AQUÍ (dentro de la función)
        const mensajeBase = fs.readFileSync("introducir-texto.txt", "utf8").trim();
        
        const nuevaLinea = `Entrada (${new Date().toLocaleString()}): ${mensajeBase}\n`;
        
        // Escribir en el log
        fs.appendFileSync("hola.txt", nuevaLinea);
        
        // Leer el resultado para mostrarlo
        const contenidoLog = fs.readFileSync("hola.txt", "utf8");
        res.send(contenidoLog);
    } catch (err) {
        res.status(500).send("Error: Asegúrate de que introducir-texto.txt existe y tiene contenido.");
    }
};

exports.getHistory = (req, res) => {
    try {
        if (fs.existsSync("hola.txt")) {
            const contenido = fs.readFileSync("hola.txt", "utf8");
            res.header("Content-Type", "text/plain");
            res.send(contenido);
        } else {
            res.send("El historial está vacío o no existe todavía.");
        }
    } catch (err) {
        res.status(500).send("Error al leer el historial.");
    }
};