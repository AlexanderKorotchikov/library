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
			$result = $db->query("SELECT * FROM books WHERE id=$id");
			/*$result->setFetchMode(PDO::FETCH_NUM);*/
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$newsItem = $result->fetch();

			$author_id = explode(',', $newsItem['authors_id']);
			foreach ($author_id as $id){
				$result2 = $db->query("SELECT * FROM author WHERE id=$id");
				while($row = $result2->fetch()) {
					$newsItem['authors'][] = [
						'name' => $row['name'],
						'surname' => $row['surname'],
						'patronymic' => $row['patronymic'],
						'date' => $row['date'],
					];
				}
			}
			$genre_id = explode(',', $newsItem['genres_id']);
			foreach ($genre_id as $id){
				$result2 = $db->query("SELECT * FROM genre WHERE id=$id");
				while($row = $result2->fetch()) {
					$newsItem['genres'][] = $row['genre'];
				}
			}
			$newsItem['picture'] = '/uploads/' . $newsItem['picture'];

			return $newsItem;
		}

	}

	/** Возвращает массив с книгами
	* @rapam integer &page - номер страницы
	*/
	public static function getBooksList($page) {

		$db = Db::getConnection();
		$booksList = array();

		$result = $db->query('SELECT * FROM books LIMIT '. NUM_BOOKS*($page - 1).','.NUM_BOOKS * $page.'');

		$count_page = $db->query('SELECT Count(*) FROM books')->fetch();
		$booksList['count_page'] = ceil((int)$count_page[0] / NUM_BOOKS);

		$i = 0;
		while($row = $result->fetch()) {
			$booksList[$i]['id'] = $row['id'];
			$booksList[$i]['name'] = $row['name'];
			$booksList[$i]['picture'] = '/uploads/'. $row['picture'];
			$booksList[$i]['description'] = $row['description'];
			$booksList[$i]['date'] = $row['date'];
			$authors[] = $row['authors_id'];
			$genres[] = $row['genres_id'];
			$i++;
		}
		$i = 0;
		foreach($authors as $author){
			$author_id = explode(',', $author);
			foreach ($author_id as $id){
				$result2 = $db->query("SELECT * FROM author WHERE id=$id");
				while($row = $result2->fetch()) {
					$data_author = [
						'name' => $row['name'],
						'surname' => $row['surname'],
						'patronymic' => $row['patronymic'],
						'date' => $row['date'],
					];
					$booksList[$i]['authors'][] = $data_author;
				}
			}
			$i++;
		}
		$i = 0;
		foreach($genres as $genre){
			$genre_id = explode(',', $genre);
			foreach ($genre_id as $id){
				$result2 = $db->query("SELECT * FROM genre WHERE id=$id");
				while($row = $result2->fetch()) {
					$booksList[$i]['genres'][] = $row['genre'];
				}
			}
			$i++;
		}
		return $booksList;
	}

}