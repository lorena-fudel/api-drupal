const fs = require('fs');

exports.handleFileAppend = (req, res) => {
    try {
        const mensajeBase = fs.readFileSync("introducir-texto.txt", "utf8").trim();
        const nuevaLinea = `Nueva entrada: ${new Date().toLocaleString()} - ${mensajeBase}\n`;
        
        fs.appendFileSync("hola.txt", nuevaLinea);
        const contenidoCompleto = fs.readFileSync("hola.txt", "utf8");
        
        res.header("Content-Type", "text/plain");
        res.send(contenidoCompleto);
    } catch (err) {
        res.status(500).send("Error procesando archivos externos.");
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