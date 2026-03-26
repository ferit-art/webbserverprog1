import express from 'express'
import users from '../data.mjs'

const router = express.Router();

router.get('/', async function (req, res) {
    res.json({ data: null })
})


router.get('/api/users', async function (req, res) { // Själva api:et
    res.json(users)
})


router.get('/api/users/:uid', async function (req, res) { // måste ta emot parameter :uid
    res.json(users[(Number)(req.params.uid) - 1])
})

export default router