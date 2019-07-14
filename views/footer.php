</body>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script>
$(function() {
   $('#primary').on('click', 'input:button', function() { //обрабатываем события радио кнопок
      $('#secondary div').hide() //скрыть все div
                         .eq($(this).index()) //получить div связанный по индексу радио кнопки 
                         .show() //сделать этот div видимым
   })
});
</script>    

</html>