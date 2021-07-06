const express = require('express')
const router = express.Router()



// Get all subscribers
router.get('/members', (req, res) => {
    const sql = "SELECT * FROM members"

    query(res, sql)
})

router.get('/member/:id', (req, res) => {
    const sql = "SELECT * FROM members WHERE id=?"
    const params = [req.params.id]

    query(res, sql, params)
})

// Create one subscriber
router.post('/member', (req, res) => {
    const sql = "INSERT INTO members(email, firstname, lastname, visibility, token) VALUES(?,?,?,?,?)"
    const { email, firstname, lastname, visibility, token } = req.body
    const params = [email, firstname, lastname, visibility, token]

    query(res, sql, params)
})

// Update one subscriber
router.patch('/member/:id', (req, res) => {
    const sql = "UPDATE members SET email=?,firstname=?,lastname=?,visibility=? WHERE id=?"
    const { email, firstname, lastname, visibility, token, id } = req.body
    const params = [email, firstname, lastname, visibility, token, id]

    query(res, sql, params)
})

// Delete one subscriber
router.delete('/member/:id', (req, res) => {
    const sql = "DELETE FROM members WHERE id=?"
    const { id } = req.body
    const params = [id]

    query(res, sql, params)
})

module.exports = router