const express = require('express')
const router = express.Router()


// Get all subscribers
router.get('/avatars', (req, res) => {
    const sql = "SELECT * FROM avatars"
    
 
})

router.get('/avatar/:id', (req, res) => {
    const sql = "SELECT * FROM avatars WHERE id=?"
    const params = [req.params.id]

    query(res, sql, params)
})

// Create one subscriber
router.post('/avatar', (req, res) => {
    const sql = "INSERT INTO avatars(email, firstname, lastname, visibility, token) VALUES(?,?,?,?,?)"
    const { email, firstname, lastname, visibility, token } = req.body
    const params = [email, firstname, lastname, visibility, token]

    query(res, sql, params)
})

// Update one subscriber
router.patch('/avatar/:id', (req, res) => {
    const sql = "UPDATE avatars SET email=?,firstname=?,lastname=?,visibility=? WHERE id=?"
    const { email, firstname, lastname, visibility, token, id } = req.body
    const params = [email, firstname, lastname, visibility, token, id]

    query(res, sql, params)
})

// Delete one subscriberx
router.delete('/avatar/:id', (req, res) => {
    const sql = "DELETE FROM avatars WHERE id=?"
    const { id } = req.body
    const params = [id]

    query(res, sql, params)
})

module.exports = router