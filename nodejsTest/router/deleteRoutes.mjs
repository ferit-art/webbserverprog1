import express from 'express'
import users from '../data.mjs'

const router = express.Router();

router.delete('/api/users', function (req, res) {
    // Efter detta fungerar inte kopplingen mellan uid och pos i users
    users.splice(req.body.uid - 1, 1)

    console.log("Deleted userID: " + req.body.uid)
    res.json({ success: true })
})

export default router