const express = require('express')
const router = express.Router()

const fetch = require('node-fetch');
const type = "robots"

// Get all subscribers
router.get('/robots', (req, res) => {
    fetch(process.env.WORDPRESS + process.env.WORDPRESS_API + type)
        .then(res => res.json())
        .then(body => {
            let array = []
            for (let index = 0; index < body.length; index++) {
                const element = body[index];
                let results = {};
                results["id"] = element["id"]
                results["niveaux"] = element["niveaux"]
                results["title"] = element["title"]["rendered"]
                results["body"] = element["content"]["rendered"]
                results["status"] = element["status"]
                results["type"] = element["type"]
                results["id_media"] = element["featured_media"]
                array.push(results)
            }
            res
                .status(200)
                .json(array)
        }
        );

    return res.status(200);

})

router.get('/robot/:id', (req, res) => {
    const sql = "SELECT * FROM robots WHERE id=?"
    const params = [req.params.id]

    query(res, sql, params)
})

// Create one subscriber
router.post('/robot', (req, res) => {
    const sql = "INSERT INTO robots(email, firstname, lastname, visibility, token) VALUES(?,?,?,?,?)"
    const { email, firstname, lastname, visibility, token } = req.body
    const params = [email, firstname, lastname, visibility, token]

    query(res, sql, params)
})

// Update one subscriber
router.patch('/robot/:id', (req, res) => {
    const sql = "UPDATE robots SET email=?,firstname=?,lastname=?,visibility=? WHERE id=?"
    const { email, firstname, lastname, visibility, token, id } = req.body
    const params = [email, firstname, lastname, visibility, token, id]

    query(res, sql, params)
})

// Delete one subscriber
router.delete('/robot/:id', (req, res) => {
    const sql = "DELETE FROM robots WHERE id=?"
    const { id } = req.body
    const params = [id]

    query(res, sql, params)
})

module.exports = router