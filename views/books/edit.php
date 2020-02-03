<?php require_once(ROOT.'/views/header.php'); ?>
  
<div class="book">
<span style="color:red;"><?php if(isset($_SESSION['error_edit'])) echo $_SESSION['error_edit'];?></span>
    <form enctype="multipart/form-data" action="" method="post">
        <span>Имя</span>
        <input type="text" value="<?=$bookList['books_name']?>" name="name" required><br>
        <span>Картинка</span>
        <img src="<?=$bookList['books_picture']?>" alt="q"><br>
        <input type="hidden" value="<?=$bookList['books_picture']?>" name="picture_old">
        <input type="file" name="picture" id=""><br>
        <span>Дата издания:</span>
        <input type="date" value="<?=$bookList['books_date']?>" name="date" required><br>
        <span>Описание</span>
        <textarea name="description" id="" cols="30" rows="10" required><?=$bookList['books_description']?></textarea><br>
        <span>Автор(ы):</span>
        <select name="authors[ ]" multiple required >
        <?php while ($row = $authors->fetch()){  ?>
            <?php 
            foreach($bookList['authors'] as $author){
                if(($author['name'] == $row['author_name']) 
                && ($author['surname'] == $row['author_surname']) 
                && ($author['patronymic'] == $row['author_patronymic']) ){
                    ?>
                    <option value="<?=$row['author_id']?>" selected><?=$row['author_name']?> <?=$row['author_surname']?></option>
                    <?php
                    $noAuthor = 1;
                    break;
                }else{ $noAuthor = 0; }
            } 
            if ($noAuthor == 0){
            ?>
                <option value="<?=$row['author_id']?>"><?=$row['author_name']?> <?=$row['author_surname']?></option>
        <?php } }?>
        </select>
<br>
        <span>Жанры:</span>
        <select name="genres[ ]" multiple required >
        <?php while ($row2 = $genres->fetch()){  ?>
            <?php 
            foreach($bookList['genres'] as $genre){
                if($genre['genre'] == $row2['genre'] ){
                    ?>
                    <option value="<?=$row2['genre_id']?>" selected><?=$row2['genre']?></option>
                    <?php
                    $noGenre = 1;
                    break;
                }else{ $noGenre = 0; }
            } 
            if ($noGenre == 0){
            ?>
                <option value="<?=$row2['genre_id']?>"><?=$row2['genre']?></option>
        <?php } }?>
        </select>
        <input type="submit" name="edit" value="Go">
    </form>

<?php require_once(ROOT.'/views/footer.php'); ?>