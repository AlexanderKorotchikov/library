<?php


class Books
{

	/** Возвращает массив с книгой по указаному id
	* @rapam integer &id
	*/

	public static function getBookByID($id)
	{
		$id = intval($id);

		if ($id) {
	
			$db = Db::getConnection();
			$sth = $db->query("SELECT b.*, a.*, g.* 
							FROM books as b 
							RIGHT JOIN books_authors au 
							ON(b.books_id = au.book_id) 
							RIGHT JOIN books_genres bg 
							ON (bg.book_id = b.books_id)
							INNER JOIN genre g 
							ON(bg.genre_id = g.genre_id)
							INNER JOIN author a 
							ON(au.author_id = a.author_id)
							WHERE b.books_id <> 'NULL' AND b.books_id = $id");
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			$sth = $sth->fetchAll();

			foreach ($sth as $row){
				$booksList['books_id'] = $row['books_id'];
				$booksList['books_name'] = $row['books_name'];
				$booksList['books_picture'] = '/uploads/'. $row['books_picture'];
				$booksList['books_description'] = $row['books_description'];
				$booksList['books_date'] = $row['books_date'];
	
				$booksList['authors'][] = [
					'id' => $row['author_id'],
					'name' => $row['author_name'],
					'surname' => $row['author_surname'],
					'patronymic' => $row['author_patronymic'],
					'date' => $row['author_date'],
				];
				$booksList['genres'][] = [
					'genre_id' => $row['genre_id'],
					'genre' => $row['genre']
				];
			}
			$booksList = self::super_unique($booksList);
			
			return $booksList;
		}

	}

	/** Возвращает массив с книгами
	* @rapam integer &page - номер страницы
	*/
	public static function getBooksList($page) {

		$db = Db::getConnection();
		$booksList = array();

		$sth = $db->query("SELECT b.*, a.*, g.* FROM 
						(SELECT * FROM books  LIMIT ". NUM_BOOKS*($page - 1).','.NUM_BOOKS * $page.") as b 
						RIGHT JOIN books_authors au 
						ON(b.books_id = au.book_id) 
						RIGHT JOIN books_genres bg 
						ON (bg.book_id = b.books_id)
						INNER JOIN genre g 
						ON(bg.genre_id = g.genre_id)
						INNER JOIN author a 
						ON(au.author_id = a.author_id)
						WHERE b.books_id <> 'NULL'
						ORDER BY b.books_id ASC");
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$sth = $sth->fetchAll();

		foreach ($sth as $row){
			$booksList[$row['books_id']]['books_id'] = $row['books_id'];
			$booksList[$row['books_id']]['books_name'] = $row['books_name'];
			$booksList[$row['books_id']]['books_picture'] = '/uploads/'. $row['books_picture'];
			$booksList[$row['books_id']]['books_description'] = $row['books_description'];
			$booksList[$row['books_id']]['books_date'] = $row['books_date'];

			$booksList[$row['books_id']]['authors'][] = [
				'name' => $row['author_name'],
				'surname' => $row['author_surname'],
				'patronymic' => $row['author_patronymic'],
				'date' => $row['author_date'],
			];
			$booksList[$row['books_id']]['genres'][] = [
				'genre_id' => $row['genre_id'],
				'genre' => $row['genre']
			];
		}
		$booksList = self::super_unique($booksList);
		$count_page = $db->query('SELECT Count(*) FROM books')->fetch();
		$booksList['count_page'] = ceil((int)$count_page[0] / NUM_BOOKS);

		return $booksList;
	}

	/** Убирает с массива повторяющиеся записи
	* @rapam arrat &array
	*/
	public static function super_unique($array){
		$result = array_map("unserialize", array_unique(array_map("serialize", $array)));

		foreach ($result as $key => $value)
		{
			if ( is_array($value) )
			{
			$result[$key] = self::super_unique($value);
			}
		}

		return $result;
	}

	/**
	 * Редактирование книги
	 */
	public static function editBook($id, $data){
		$db = Db::getConnection();
	
		$sql = "UPDATE `books` SET `books_name`= ?, `books_picture`= ?, `books_description`= ?, `books_date`= ? WHERE `books_id` = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$data['name'], $data['picture'], $data['description'], $data['date'], $id]);
		
		$db->query("DELETE FROM `books_authors` WHERE `book_id` = $id");
		$db->query("DELETE FROM `books_genres` WHERE `book_id` = $id");
		

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