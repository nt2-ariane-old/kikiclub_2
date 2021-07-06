const express = require('express')
const router = express.Router()

const fetch = require('node-fetch');
const type = "media"
// Get all medias
router.get('/medias', (req, res) => {
    fetch(process.env.WORDPRESS + process.env.WORDPRESS_API + type)
        .then(res => res.json())
        .then(body => {
            let array = []
            for (let index = 0; index < body.length; index++) {
                const element = body[index];
                let results = {};
                results["id"] = element["id"]
                results["path"] = element["source_url"]
                array.push(results)
            }
            res
                .status(200)
                .json(array)
        }
        );
    return res.status(200);

})

router.get('/media/:id', (req, res) => {
    const id = req.params.id
    fetch(process.env.WORDPRESS + process.env.WORDPRESS_API + type + "/" + id)
        .then(res => res.json())
        .then(body => {
            let results = {};
            results["id"] = body["id"]
            results["path"] = body["source_url"]
            res
                .status(200)
                .json(results)
        }
        );
    return res.status(200);

})

// Create one subscriber
router.post('/media', (req, res) => {
    const sql = "INSERT INTO medias(email, firstname, lastname, visibility, token) VALUES(?,?,?,?,?)"
    const { email, firstname, lastname, visibility, token } = req.body
    const params = [email, firstname, lastname, visibility, token]

    query(res, sql, params)
})

// Update one subscriber
router.patch('/media/:id', (req, res) => {
    const sql = "UPDATE medias SET email=?,firstname=?,lastname=?,visibility=? WHERE id=?"
    const { email, firstname, lastname, visibility, token, id } = req.body
    const params = [email, firstname, lastname, visibility, token, id]

    query(res, sql, params)
})

// Delete one subscriber
router.delete('/media/:id', (req, res) => {
    const sql = "DELETE FROM medias WHERE id=?"
    const { id } = req.body
    const params = [id]

    query(res, sql, params)
})

module.exports = router