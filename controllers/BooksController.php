<?php

include_once ROOT. '/models/Books.php';

class BooksController {

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

}

