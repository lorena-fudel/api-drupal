const jwt = require('jsonwebtoken');
const SECRET_KEY = process.env.JWT_SECRET;

exports.login = (req, res) => {
    const user = { 
        id: 1, 
        name: "Super-admin", 
        entities: ["Sede Central", "Soporte Técnico"] 
    };
    const token = jwt.sign({ user }, SECRET_KEY, { expiresIn: '1h' });
    res.json({ token });
};

exports.getProfiles = (req, res) => {
    // Formato exacto según la documentación aportada 
    res.json({
        myprofiles: [
            {
                id: req.userData.id,
                name: req.userData.name,
                entities: req.userData.entities // Array de entidades 
            }
        ]
    });
};