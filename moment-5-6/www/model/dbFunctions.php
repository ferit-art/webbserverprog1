<?php

/**
 * Anluter till databasen och returnerar ett PDO-objekt
 * @return PDO  Objektet som returneras
 */
function connectToDb()
{
    // Definierar konstanter med användarinformation.
    define('DB_USER', 'user');
    define('DB_PASSWORD', '12345');
    define('DB_HOST', 'mariadb'); // mariadb om docker annars localhost
    define('DB_NAME', 'egytalk');

    // Skapar en anslutning till MySql och databasen egytalk
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
    $db = new PDO($dsn, DB_USER, DB_PASSWORD);

    return $db;
}

/**
 * Hämtar alla status-uppdateringar i tabellen post
 *
 * @param $db PDO-objekt
 * @return array med alla status-uppdateringar
 */
function getAllPosts($db)
{
    $sqlkod = "SELECT post.*, user.firstname, user.surname, user.username FROM post NATURAL JOIN user ORDER BY post.date LIMIT 0,30";

    /* Kör frågan mot databasen egytalk och tabellen post */
    $stmt = $db->prepare($sqlkod);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// uppgift 8

function getUserFromUid($db, $uid)
{
    $sqlkod = "SELECT username, firstname, surname FROM user WHERE uid LIKE ? ORDER BY username";
    $stmt = $db->prepare($sqlkod);
    $stmt->bindValue(1, "$uid%", PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// uppgift 9

function getPostsFromUid($db, $uid)
{
    $sqlkod = "SELECT post.*, user.firstname, user.surname, user.username FROM post JOIN user ON post.uid = user.uid WHERE post.uid LIKE ? ORDER BY post.date";
    $stmt = $db->prepare($sqlkod);
    $stmt->bindValue(1, "$uid%", PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// uppgift 10

function getPostsWithCommentsFromUid($db, $uid)
{
    $sqlkod = "SELECT 
            post.pid,
            post.post_txt,
            post.date,
            post.uid           AS post_uid,
            post_user.username AS post_username,
            comment.cid,
            comment.comment_txt,
            comment_user.username AS comment_username
        FROM post
        JOIN user AS post_user ON post.uid = post_user.uid
        LEFT JOIN comment ON post.pid = comment.pid
        LEFT JOIN user AS comment_user ON comment.uid = comment_user.uid
        WHERE post.uid = ?
        ORDER BY post.date DESC, comment.date ASC";

    $stmt = $db->prepare($sqlkod);
    $stmt->bindValue(1, $uid, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];

    foreach ($rows as $row) {

        if (!isset($result[$row['pid']])) {
            $result[$row['pid']] = [
                'pid' => $row['pid'],
                'post_txt' => $row['post_txt'],
                'date' => $row['date'],
                'sender' => [
                    'username' => $row['post_username'],
                    'uid' => $row['post_uid']
                ],
            ];
        }

        if ($row['cid'] !== null) {
            $result[$row['pid']]['comments'][] = [
                'cid' => $row['cid'],
                'sender' => $row['comment_username'],
                'comment_txt' => $row['comment_txt']
            ];
        }
    }
    return array_values($result);
}

// uppgift 11 och 12

function getAllPostsWithComments($db)
{
    $sqlkod = "SELECT 
            post.pid           AS post_pid,
            post.uid           AS post_uid,
            post.post_txt,
            post.date AS post_date,
            post_user.firstname AS post_firstname,
            post_user.surname AS post_surname,
            comment.cid,
            comment.pid,
            comment.uid AS comment_uid,
            comment.comment_txt,
            comment.date,
            comment_user.firstname AS comment_firstname,
            comment_user.surname AS comment_surname
        FROM post
        JOIN user AS post_user ON post.uid = post_user.uid
        LEFT JOIN comment ON post.pid = comment.pid /* => Only include rows from the comment table where the pid matches the current post’s pid */
        LEFT JOIN user AS comment_user ON comment.uid = comment_user.uid /* => Same as above but it is for the uid now */
        ORDER BY post.date DESC, comment.date ASC";

    $stmt = $db->prepare($sqlkod);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];

    foreach ($rows as $row) {

        if (!isset($result[$row['post_pid']])) { /* => Post 3 dras ner som null i pid och date?? */ 
            $result[$row['post_pid']] = [
                'pid' => $row['post_pid'],
                'post_txt' => $row['post_txt'],
                'date' => $row['post_date'],
                'sender' => [
                    'firstname' => $row['post_firstname'],
                    'surname' => $row['post_surname'],
                    'uid' => $row['post_uid']
                ],
            ];
        }

        if ($row['cid'] !== null) {
            $result[$row['post_pid']]['comments'][] = [
                'cid' => $row['cid'],
                'firstname' => $row['comment_firstname'],
                'surname' => $row['comment_surname'],
                'comment_txt' => $row['comment_txt']
            ];
        }
    }
    return array_values($result);
}
