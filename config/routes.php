<?php
return array(
	'books/edit/([0-9]+)' => 'books/edit/$1',
	'books/page/([0-9]+)' => 'books/index/$1',
	'books/([0-9]+)' => 'books/view/$1',
	'books' => 'books/index', 
	'add' => 'index/add',
	'' => 'index/index',
	);