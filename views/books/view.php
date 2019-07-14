<?php require_once('/views/header.php'); ?>
  
<div class="book">
<p><?=$bookList['name']?></p>
<img src="<?=$bookList['picture']?>" alt="q">
<p><?=$bookList['description']?></p>
Дата издания:<span><?=$bookList['date']?></span><br>
Автор(ы): <?php foreach($bookList['authors'] as $author){ ?>
    <span><?=$author['name']?> <?=$author['surname']?> <?=$author['patronymic']?></span> | 
<?php } ?>
<hr>
Жанр(ы): <?php foreach($bookList['genres'] as $genre){ ?>
    <span><?=$genre?></span> | 
<?php } ?><br>
<input type="button" class="back" onclick="history.back()" value="Назад">
</div>
<?php require_once('/views/footer.php'); ?>