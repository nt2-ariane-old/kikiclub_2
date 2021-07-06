const express = require('express')
const router = express.Router()

const db = require('../db/db')
const query = db.query

const loginQuery = db.loginQuery
const tokenQuery = db.tokenQuery

const fetch = require('node-fetch');
const type = "robots"

const generateString = (length) => {
    const range = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    let final_string = "";

    for (let index = 0; index < range.length; index++) {
        const element = range.charAt(Math.floor(Math.random() * length));
        final_string += element
    }

    return final_string;
}
// Get all subscribers
router.get('/users', (req, res) => {
    const sql = "SELECT * FROM users"

    query(res, sql)
})

router.get('/user/:id', (req, res) => {
    const sql = "SELECT * FROM users WHERE id=?"
    const params = [req.params.id]

    query(res, sql, params)
})
router.get('/user/:id/member', (req, res) => {
    const sql = "SELECT * FROM members WHERE id_user=? ORDER BY birthday DESC"
    const params = [req.params.id]

    query(res, sql, params)
})

router.get('/user/token/:token', (req, res) => {
    const params = [req.params.token]
    tokenQuery(res, params)
})

// Create one subscriber
router.post('/user', (req, res) => {
    const sql = "INSERT INTO users(email, firstname, lastname, visibility, token) VALUES(?,?,?,?,?)"
    const { email, firstname, lastname, visibility, token } = req.body
    const params = [email, firstname, lastname, visibility, token]

    query(res, sql, params)
})

router.post('/login', (req, res) => {
    const { email, password } = req.body
    const body = { username: email, password }
    const url = process.env.WORDPRESS + process.env.WORDPRESS_API + 'kikiclub/login'
    console.log(url)
    fetch(process.env.WORDPRESS + process.env.WORDPRESS_API + 'kikiclub/login', {
        method: 'post',
        body: JSON.stringify(body),
        headers: { 'Content-Type': 'application/json' },
    })
        .then(res => res.json())
        .then(json =>
            res
                .status(200)
                .json(json));
    return res.status(200);
})

// Update one subscriber
router.patch('/user/:id', (req, res) => {
    const sql = "UPDATE users SET email=?,firstname=?,lastname=?,visibility=? WHERE id=?"
    const { email, firstname, lastname, visibility, token, id } = req.body
    const params = [email, firstname, lastname, visibility, token, id]

    query(res, sql, params)
})

// Delete one subscriber
router.delete('/user/:id', (req, res) => {
    const sql = "DELETE FROM users WHERE id=?"
    const { id } = req.body
    const params = [id]

    query(res, sql, params)
})

module.exports = router