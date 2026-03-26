import express from "express"
import users from "./data.mjs"
import cors from "cors"

// Importera api:endpoints

import createRouter from "./router/createRoutes.mjs"
import readRouter from "./router/readRoutes.mjs"
import updateRouter from "./router/updateRoutes.mjs"
import deleteRouter from "./router/deleteRoutes.mjs"

const app = express()


// ---- Middleware ----
app.use(cors()) // Tillåter anrop från annan domän
app.use(express.urlencoded({ extended: true })); // body urlencoded
app.use(express.json()) // body i json-formatet


app.use(function (req, res, next) {
    console.log("Hello Express Server")
    next(); // Går vidare till nästa middleware-funktion
})

app.use(readRouter)
app.use(createRouter)
app.use(deleteRouter)
app.use(updateRouter)
// -- End Middleware --


/** Startar servern och lyssnar på port 5000 */
app.listen(5000)

