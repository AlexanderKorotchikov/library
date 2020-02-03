<?php

include_once ROOT. '/models/Books.php';

class BooksController extends Controller {

	/**
	 * Методо обработки запросов: /books, /books/page/([0-9])+
	 * parram integer page - номер страницы
	 */
	public function actionIndex($page = 1)
	{
		$booksList = array();
		$booksList = Books::getBooksList($page);
		$count_page = $booksList['count_page'];
		unset($booksList['count_page']);
		require_once(ROOT . '/views/books/index.php');

		return true;
	}

	/**
	 * Метод обработки запроса /books/([0-9])+
	 * param integer id
	 */
	public function actionView($id)
	{
		if ($id) {
			$bookList = Books::getBookByID($id);
			require_once(ROOT . '/views/books/view.php');
		}

		return true;

	}

	/**
	 * Метод обработки запроса /books/edit/([0-9])+
	 * param integer &id
	 */
	public function actionEdit($id)
	{
		if (isset($_POST['edit'])){
			
			if ((!isset($_POST['authors'])) && ($_POST['authors'] == NULL)){
				$_SESSION['error_edit'] = 'Заполните поля правильно! Теги не допускаются!';
				header("Location: /books/edit/$id");
				exit();
			} 
			if ((!isset($_POST['genres'])) && ($_POST['genres'] == NULL)){
				$_SESSION['error_edit'] = 'Заполните поля правильно! Теги не допускаются!';
				header("Location: /books/edit/$id");
				exit();
			}
			
			if ((!isset($_FILES['picture']['name'])) || ($_FILES['picture']['name'] == NULL)){
				$_POST['picture'] = explode('/',$_POST['picture_old'])[2];	
			}
			else{
				$_POST['picture'] = $_FILES['picture']['name'];
				$uploaddir = ROOT . '/uploads/';
				$uploadfile = $uploaddir . basename($_FILES['picture']['name']);
		
				if (!move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile)) {
					return false;
				}
			}

			if ($this->validateForm($_POST)){
				if(Books::editBook($id, $_POST)){
					$_SESSION['error_edit'] = '';
					header("Location: /books/$id");
					exit();
				}
			}else{
				$_SESSION['error_edit'] = 'Заполните поля правильно! Теги не допускаются!';
				header("Location: /books/edit/$id");
				exit();
			}

			return true;
		}

		include_once ROOT. '/models/Index.php';
		if ($id) {
			$bookList = Books::getBookByID($id);
			$authors = Index::getAuthors();
			$genres = Index::getGenre();
			require_once(ROOT . '/views/books/edit.php');
		}

		
		return true;
	}
}

