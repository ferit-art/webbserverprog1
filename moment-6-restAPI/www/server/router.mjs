import connectToDB from './mariadb/connect.mjs'
import bcrypt from 'bcrypt';
import express from "express"
import jwt from 'jsonwebtoken';
import { serialize, parse } from 'cookie';
import dotenv from 'dotenv'

dotenv.config()
const router = express.Router()

/**
 * Middleware för att lägga till en användare i user-tabellen.
 * Endpoint: /api/users
 * Method: POST
 */
router.post('/users', async function (req, res) {
   const result = { success: false }
   const cost = 10

   // Alternativt: const { firstName, surName, userName, password } = req.body;
   const firstName = req.body.firstName
   const surName = req.body.surName
   const userName = req.body.userName
   const password = req.body.password

   try {
      const passwordHash = await bcrypt.hash(password, cost);
      const connection = await connectToDB();
      const sql = "INSERT INTO user(uid, firstname, surname, username, password) VALUES(UUID(),?,?,?,?)";
      await connection.execute(sql, [firstName, surName, userName, passwordHash]);
      connection.end();
      result.success = true;
   } catch (err) {
      console.error(err);
   }

   res.json(result);
})

/**
 * Middleware för att autentisera en användare med användarnamn och lösenord.
 * Om autentisering lyckas skapas en cookie med en JWT och returnerar {success: true}.
 * Endpoint: /api/auth
 * Method: POST
 */
router.post('/auth', async function (req, res) {

   // Alternativt: const { userName, password } = req.body;
   const userName = req.body.userName
   const password = req.body.password

   const result = await authenticateUser(userName, password);

   if (!result.success) {
      res.json(result)
      return;
   }

   const uid = result.userInfo.uid
   const JWTToken = jwt.sign({ uid }, process.env.JWT_SECRET, { expiresIn: '4h' });

   const cookie = serialize('jwt', JWTToken, {
      httpOnly: true,
      secure: process.env.NODE_ENV === 'production', // Använd secure flaggan endast i produktion
      sameSite: 'Strict',  // 'Lax'
      maxAge: 14400, // 4 timmar
      path: '/'
   });

   res.setHeader('Set-Cookie', cookie)

   res.json(result)
})

/**
 * Middleware för att logga ut användare.
 * Endpoint: /api/logout
 * Method: POST
 */
router.post('/logout', function (req, res) {
   const cookie = serialize('jwt', '', {
      httpOnly: true,
      secure: process.env.NODE_ENV === 'production',
      sameSite: 'strict',
      expires: new Date(0), // Sätter ett utgånget datum
      path: '/'
   });

   res.setHeader('Set-Cookie', cookie);
   res.json({ success: true });
});

router.get('/*', async function (req, res, next) {
   const result = await getUserFromCookie(req.headers.cookie);

   if (result.success) {
      req.user = result.userInfo;
      req.success = result.success;
   } else {
      req.user = null;
      req.success = false;
   }
   next();
})

/**
 * Middleware för att autentisera mot en JWT-cookie.
 * Om autentisering lyckas returneras {success: true}.
 * Endpoint: /api/auth
 * Method: GET
 */
router.get('/auth', async function (req, res) {
   res.json({ success: req.success, userInfo: req.user });
})

/**
 * Middleware för att returnera alla användare om JWT-cookien kan verifieras.
 * Endpoint: /api/users
 * Method: GET
 */
router.get('/users', async function (req, res) {
   let result = { success: req.success, userInfo: req.user }

   if (!result.success) {
      res.json(result)
      return;
   }

   try {
      const connection = await connectToDB()
      const sql = "SELECT uid, firstName, surName, userName FROM user"
      const [rows,] = await connection.execute(sql)
      connection.end()

      result.success = true
      result.userInfo = rows
   } catch (err) {
      console.error(err);
   }

   res.json(result);
})

// Uppgift 3

router.get('/users/:uid', async function (req, res) {
   let result = { success: req.success, userInfo: req.user }

   if (!result.success) {
      res.json(result)
      return;
   }

   try {
      const connection = await connectToDB()
      const sql = "SELECT uid, firstName, surName, userName FROM user WHERE uid = ?"
      const [rows,] = await connection.execute(sql, [req.params.uid])

      connection.end()

      result.success = true
      result.userInfo = rows;
   } catch (err) {
      console.error(err);
      result.success = false;
   }

   res.json(result);
})

// Uppgift 4 och 5

router.get('/posts/:uid', async function (req, res) {
   let result = { success: req.success, userInfo: req.user }

   if (!result.success) {
      res.json(result)
      return;
   }

   // 1 - Hämta alla poster för en person som sparas i arrayen posts.
   let connection;

   try {
      connection = await connectToDB()
      const postsSql = "SELECT post.*, user.firstname, user.surname, user.username FROM post JOIN user ON post.uid = user.uid WHERE post.uid = ? ORDER BY post.date"
      const [posts] = await connection.execute(postsSql, [req.params.uid])

      // 2 - Loopa igenom arrayen posts

      for (const post of posts) {
         // 3 - och hämta alla kommentarer till varje post

         const commentsSql = "SELECT comment.*, user.uid, user.firstname, user.surname FROM comment JOIN user ON comment.uid = user.uid WHERE pid=? ORDER BY comment.date"
         const [comments] = await connection.execute(commentsSql, [post.pid])

         // 4 - Lägg till i arrayen, posts, kommentarerna till den aktuella posten. Ett nytt associativt index behövs. I mitt fall "comments", se nedan på resultatet av körningen.

         post.comments = comments;
      }

      result.success = true;
      result.postInfo = posts;

   } catch (err) {
      console.error(err);
      result.success = false;
      result.message = "Server error"
   } finally {
      await connection.end;
   }
   res.json(result);
})

// Uppgift 6 och 7

router.get('/posts', async function (req, res) {
   let result = { success: req.success, userInfo: req.user }

   if (!result.success) {
      res.json(result)
      return;
   }

   // 1 - Hämta alla poster som sparas i arrayen posts.
   let connection;

   try {
      connection = await connectToDB()
      const postsSql = "SELECT post.*, user.firstname, user.surname, user.username FROM post JOIN user ON post.uid = user.uid ORDER BY post.date"
      const [posts] = await connection.execute(postsSql)

      // 2 - Loopa igenom arrayen posts

      for (const post of posts) {
         // 3 - och hämta alla kommentarer till varje post

         const commentsSql = "SELECT comment.*, user.uid, user.firstname, user.surname FROM comment JOIN user ON comment.uid = user.uid WHERE pid=? ORDER BY comment.date"
         const [comments] = await connection.execute(commentsSql, [post.pid])

         // 4 - Lägg till i arrayen, posts, kommentarerna till den aktuella posten. Ett nytt associativt index behövs. I mitt fall "comments", se nedan på resultatet av körningen.

         post.comments = comments;
      }

      result.success = true;
      result.postInfo = posts;

   } catch (err) {
      console.error(err);
      result.success = false;
      result.message = "Server error"
   } finally {
      await connection.end;
   }
   res.json(result);
})

/**
 * Middleware för att hantera övriga anrop till domän/api.
 * Endpoint: /api/*
 * Method: GET
 */
router.get('/*', function (req, res) {
   res.json({ success: false })
})

/**
 * Funktion för att autentisera en användare med användarnamn och lösenord.
 * Returnerar all användardata (ej lösenord) om autentisering lyckas.
 * 
 * @param {string} userName 
 * @param {string} password 
 * @returns {Object} { success: false/true, userInfo: [] }
 */
async function authenticateUser(userName, password) {
   let result = { success: false, userInfo: [] }
   try {
      const connection = await connectToDB()
      const sql = "SELECT * FROM user WHERE  username = ?"
      const [rows,] = await connection.execute(sql, [userName])

      connection.end()

      if (rows.length == 1) {
         result.userInfo = rows[0]
         if (await bcrypt.compare(password, result.userInfo.password)) {
            result.success = true;
            delete result.userInfo['password'];
         } else {
            result.userInfo = [];
         }
      }
   } catch (err) {
      console.error(err);
   }

   return result
}

/**
 * Funktion för att autentisera mot en cookie.
 * Om autentisering lyckas returneras all användardata förutom lösenord.
 * 
 * @param {string} cookie 
 * @returns {Object} { success: true/false, userInfo: [] }
 */
async function getUserFromCookie(cookie) {
   let result = { success: false, userInfo: [] }

   if (!cookie) {
      return result;
   }

   const cookies = parse(cookie);

   // Hämta JWT från cookies
   const token = cookies.jwt;

   if (!token) {
      return result;
   }

   let decodedJWT

   try {
      // Verifiera JWT
      decodedJWT = jwt.verify(token, process.env.JWT_SECRET);
   } catch (err) {
      console.error(err)
      return result;
   }
   return await getUserFromUid(decodedJWT.uid);
}

async function getUserFromUid(uid) {
   let result = { success: false, userInfo: [] };

   try {
      const connection = await connectToDB()
      const sql = "SELECT user.firstname, user.surname FROM user WHERE uid = ?"
      const [rows,] = await connection.execute(sql, [uid])

      connection.end()

      if (rows.length == 1) {
         result.success = true;
         result.userInfo = rows[0];
         delete result.userInfo.password;
      }
   } catch (err) {
      console.error(err);
   }

   return result;
}

export default router