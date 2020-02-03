<?php


class Index
{

    /** Возврощает массив с авторами (array &authors)**/
    public static function getAuthors(){

        $db = Db::getConnection();

        $authors = $db->query("SELECT * FROM author");

        return $authors;
    }

    /** Возврощает массив с жанрами (array &genre)**/
    public static function getGenre(){

        $db = Db::getConnection();

        $genre = $db->query("SELECT * FROM genre");

        return $genre;
    }

    /** Добавить автора в бд */
	public static function addAuthor($data){
        $db = Db::getConnection();
        // var_dump($data);
        $sql = "INSERT INTO author (author_name, author_surname, author_patronymic, author_date) VALUES (?,?,?,?)";
        $stmt= $db->prepare($sql);
        $stmt->execute([$data['name'], $data['surname'], $data['patronymic'], $data['date']]);

        if($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

        
    }

    /** Добавить жанр в бд */
    public static function addGenre($data){
        $db = Db::getConnection();

        $sql = "INSERT INTO genre (genre) VALUES (?)";
        $stmt= $db->prepare($sql);
        $stmt->execute([$data['genre']]);

        if($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /** Добавить книгу в бд */
    public static function addBook($data){
        $db = Db::getConnection();
        
        $sql = "INSERT INTO books (books_name, books_picture, books_description, books_date) VALUES (?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$data['name'], $data['picture'], $data['description'], $data['date']]);
        $id = $db->lastInsertId();

        foreach($data['authors'] as $author){
            $sql = "INSERT INTO books_authors (book_id, author_id) VALUES (?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id, $author]);
        }

        foreach($data['genres'] as $genre){
            $sql = "INSERT INTO books_genres(book_id, genre_id) VALUES (?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id, $genre]);
        }
        if($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}