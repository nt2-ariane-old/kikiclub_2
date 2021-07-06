const express = require('express')
const router = express.Router()

// const db = require('../db/db')
// const query = db.query
const fetch = require('node-fetch');
const type = "ateliers"
// Get all workshops
router.get('/workshops', (req, res) => {
    fetch(process.env.WORDPRESS + process.env.WORDPRESS_API + type)
        .then(res => res.json())
        .then(body => {
            let array = []
            for (let index = 0; index < body.length; index++) {
                const element = body[index];
                let results = {};
                results["id"] = element["id"]
                results["difficultes"] = element["difficultes"]
                results["niveaux"] = element["niveaux"]
                results["robots"] = element["robots_taxo"]
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

router.get('/workshop/:id', (req, res) => {
    const id = req.params.id
    fetch(process.env.WORDPRESS + process.env.WORDPRESS_API + type + "/" + id)
        .then(res => res.json())
        .then(body => {
            let array = []
            for (let index = 0; index < body.length; index++) {
                const element = body[index];
                let results = {};
                results["id"] = element["id"]
                results["difficultes"] = element["difficultes"]
                results["niveaux"] = element["niveaux"]
                results["robots"] = element["robots_taxo"]
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

// Create one subscriber
router.post('/workshop', (req, res) => {
    const sql = "INSERT INTO workshops(email, firstname, lastname, visibility, token) VALUES(?,?,?,?,?)"
    const { email, firstname, lastname, visibility, token } = req.body
    const params = [email, firstname, lastname, visibility, token]

    query(res, sql, params)
})

// Update one subscriber
router.patch('/workshop/:id', (req, res) => {
    const sql = "UPDATE workshops SET email=?,firstname=?,lastname=?,visibility=? WHERE id=?"
    const { email, firstname, lastname, visibility, token, id } = req.body
    const params = [email, firstname, lastname, visibility, token, id]

    query(res, sql, params)
})

// Delete one subscriber
router.delete('/workshop/:id', (req, res) => {
    const sql = "DELETE FROM workshops WHERE id=?"
    const { id } = req.body
    const params = [id]

    query(res, sql, params)
})

module.exports = router