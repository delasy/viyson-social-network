<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Long-Polling chat</title>
        <script src="http://codeorigin.jquery.com/jquery-1.10.2.min.js"></script>
        <script>
            function send(e) {
                window.connection.abort();
                $.post("add.php", $(e).serialize() , function () {
                    $(e).find("textarea").val("").focus();
                });
            }

            $(function () {
                $("textarea").keyup(function (e) {
                    if (e.keyCode==13) {
                        send("form");
                        return false;
                    }
                });
            });
        </script>
    </head>

    <body>
        <ul>
            <li><b>Тут появятся сообщения:</b></li>
			<?
				$db = new mysqli("mysql.hostinger.com.ua", "u533043863_viy", "secret", "u533043863_viy");
				$q = $db->query("SELECT `text` FROM `messages`");
				while($r = $q->fetch_assoc()['text']) {
				 echo "<li>" . $r . "</li>";
				}
			?>
        </ul>
        <hr>
        <form onsubmit="send(this);return false;">
            <textarea placeholder="Введите сообщение" name="text"></textarea>
            <input type="submit" value="GO!" />
        </form>
    </body>
</html>
