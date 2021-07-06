const express = require('express')
const router = express.Router()



// Get all subscribers
router.get('/member_workshopss', (req, res) => {
    const sql = "SELECT * FROM member_workshopss"

    query(res, sql)
})

router.get('/member_workshops/:id', (req, res) => {
    const sql = "SELECT * FROM member_workshopss WHERE id=?"
    const params = [req.params.id]

    query(res, sql, params)
})
router.get('/member/:id/workshops', (req, res) => {
    const sql = "SELECT * FROM workshops WHERE id IN (SELECT ID_WORKSHOP FROM member_workshops WHERE ID_MEMBER=?) "
    const params = [req.params.id]

    query(res, sql, params)
})
router.get('/member/:id/workshops/categories', (req, res) => {
    const sql = "SELECT w.id as id, ws.name_fr as statut, id_workshop, w.name as name, w.media_path as media_path, w.media_type as media_type FROM member_workshops as mw JOIN workshop_statut as ws JOIN workshops as w WHERE ID_MEMBER=? AND mw.id_statut = ws.id AND mw.id_workshop = w.id "
    const params = [req.params.id]

    query(res, sql, params)
})

// Create one subscriber
router.post('/member_workshops', (req, res) => {
    const sql = "INSERT INTO member_workshopss(email, firstname, lastname, visibility, token) VALUES(?,?,?,?,?)"
    const { email, firstname, lastname, visibility, token } = req.body
    const params = [email, firstname, lastname, visibility, token]

    query(res, sql, params)
})

// Update one subscriber
router.patch('/member_workshops/:id', (req, res) => {
    const sql = "UPDATE member_workshopss SET email=?,firstname=?,lastname=?,visibility=? WHERE id=?"
    const { email, firstname, lastname, visibility, token, id } = req.body
    const params = [email, firstname, lastname, visibility, token, id]

    query(res, sql, params)
})

// Delete one subscriberx
router.delete('/member_workshops/:id', (req, res) => {
    const sql = "DELETE FROM member_workshopss WHERE id=?"
    const { id } = req.body
    const params = [id]

    query(res, sql, params)
})

module.exports = router