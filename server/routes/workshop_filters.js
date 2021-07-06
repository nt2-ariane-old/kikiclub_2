const express = require('express')
const router = express.Router()

// const db = require('../db/db')
// const query = db.query

const fetch = require('node-fetch');
const type = "taxonomies"
// Get all subscribers
router.get('/workshop_filters', async (req, res) => {
    let results = {}
    results["difficultes"] = await getTaxonomies("difficultes")
    results["niveaux"] = await getTaxonomies("niveaux")
    results["robots"] = await getTaxonomies("robots_taxo")
    return res.status(200).json(results);
})
getTaxonomies = async (subtype) => {
    let array = []
    await fetch(process.env.WORDPRESS + process.env.WORDPRESS_API + subtype + "?per_page=99")
        .then(res => res.json())
        .then(body => {
            for (let index = 0; index < body.length; index++) {
                const element = body[index];
                let results = {}
                results["id"] = element["id"]
                results["name"] = element["name"]
                results["slug"] = element["slug"]
                array.push(results)
            }
        }
        );
    return array
}

router.get('/workshop_filter/:subtype/:id', async (req, res) => {
    const subtype = req.params.subtype
    const id = req.params.id

    let results = {}
    await fetch(process.env.WORDPRESS + process.env.WORDPRESS_API + subtype + "/" + id)
        .then(res => res.json())
        .then(body => {
            results["name"] = body["name"]
            results["slug"] = body["slug"]
        }
        );
    return res.status(200).json(results);

})

// Create one subscriber
router.post('/filter', async (req, res) => {
    const { difficultes, robots, niveaux } = req.body
    let difficultes_string = null, niveaux_string = null, robots_string = null
    if (difficultes)
        difficultes_string = "difficultes=" + difficultes.map((diff) => diff)
    if (niveaux)
        niveaux_string = "niveaux=" + niveaux.map((lvl) => lvl)
    if (robots)
        robots_string = "robots_taxo=" + robots.map((bot) => bot + ",")

    let array = []
    const url = process.env.WORDPRESS + process.env.WORDPRESS_API + "ateliers?" + (difficultes_string ? difficultes_string + "&&": "")  + (niveaux_string ? niveaux_string+ "&&" : "" ) + (robots_string ? robots_string : "")
    await fetch(url)
        .then(res => res.json())
        .then(body => {
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
        }
        );
    return res.status(200).json(array);
})

// Update one subscriber
router.patch('/workshop_filter/:id', (req, res) => {
    const sql = "UPDATE workshop_filters SET email=?,firstname=?,lastname=?,visibility=? WHERE id=?"
    const { email, firstname, lastname, visibility, token, id } = req.body
    const params = [email, firstname, lastname, visibility, token, id]

    query(res, sql, params)
})

// Delete one subscriberx
router.delete('/workshop_filter/:id', (req, res) => {
    const sql = "DELETE FROM workshop_filters WHERE id=?"
    const { id } = req.body
    const params = [id]

    query(res, sql, params)
})

module.exports = router