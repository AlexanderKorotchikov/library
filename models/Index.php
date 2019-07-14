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
        $sql = "INSERT INTO author (name, surname, patronymic, date) VALUES (?,?,?,?)";
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
        
        $authors = '';
        foreach($data['authors'] as $author){
            if($authors == '') $authors = $author;
            else $authors .= ',' . $author;
        }

        $genres = '';
        foreach($data['genres'] as $genre){
            if($genres == '') $genres = $genre;
            else $genres .= ',' . $genre;
        }
        // var_dump($data);
        $sql = "INSERT INTO books (name, picture, description, date, authors_id, genres_id) VALUES (?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$data['name'], $data['picture'], $data['description'], $data['date'], $authors, $genres]);
        
        if($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}