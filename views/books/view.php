<?php require_once(ROOT.'/views/header.php'); ?>
  
<div class="book">
<p><?=$bookList['books_name']?></p>
<img src="<?=$bookList['books_picture']?>" alt="q">
<p><?=$bookList['books_description']?></p>
Дата издания:<span><?=$bookList['books_date']?></span><br>
Автор(ы): <?php foreach($bookList['authors'] as $author){ ?>
    <span><?=$author['name']?> <?=$author['surname']?> <?=$author['patronymic']?></span> | 
<?php } ?>
<hr>
Жанр(ы): <?php foreach($bookList['genres'] as $genre){ ?>
    <span><?=$genre['genre']?></span> | 
<?php } ?><br>
<a class="back" href="/books">Назад</a>
<a class="edit" href="/books/edit/<?=$bookList['books_id']?>">Редактироваь</a>
</div>
<?php require_once(ROOT.'/views/footer.php'); ?>