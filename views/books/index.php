<?php require_once(ROOT.'/views/header.php'); ?>

<?php foreach($booksList as $book){ ?>
    <div id="book-<?=$book['books_id']?>" class="book">
    <p><?=$book['books_name']?></p>
    <a href="/books/<?=$book['books_id']?>"><img src="<?=$book['books_picture']?>" alt="q"></a>
    <p><?=mb_strimwidth($book['books_description'], 0, 300, "...");?></p>
    Дата издания: <span><?=$book['books_date']?></span><br>
    Автор(ы): <?php foreach($book['authors'] as $author){ ?>
        <span><?=$author['name']?> <?=$author['surname']?> <?=$author['patronymic']?> (<?=$author['date']?>)</span> |
    <?php } ?><hr>
    Жанр(ы): <?php foreach($book['genres'] as $genre){ ?>
        <span><?=$genre['genre']?></span> | 
    <?php } ?><br><hr>
    <a href="/books/<?=$book['books_id']?>">читать</a>
    </div>
<?php } ?>

<nav class="text-center">
    <ul class="pagination">
        <?php for($i=1;$i<=$count_page;$i++){ ?>
            <li><a href="/books/page/<?=$i?>"><?=$i?></a></li>
        <?php } ?>
    </ul>
</nav>



<?php require_once(ROOT.'/views/footer.php'); ?>