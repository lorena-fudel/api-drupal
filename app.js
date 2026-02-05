require('dotenv').config();
const express = require('express');
const app = express();

// Importar las rutas
const authRoutes = require('./routes/authRoutes'); // Verifica el nombre exacto del archivo 
const fileRoutes = require('./routes/fileRoutes');
app.use(express.json());

// Usar las rutas con prefijos para organizar tu API
app.use('/auth', authRoutes); // Ahora será /auth/login y /auth/getMyProfiles
app.use('/files', fileRoutes); // Ahora será /files/hola

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Servidor escalable en puerto ${PORT}`)); 