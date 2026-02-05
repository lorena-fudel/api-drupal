const express = require('express');
const router = express.Router();
const authController = require('../controllers/authController');
const verifyToken = require('../middlewares/authMiddleware');

router.get('/login', authController.login);
router.get('/getMyProfiles', verifyToken, authController.getProfiles);

module.exports = router;