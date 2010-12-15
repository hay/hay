<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
    <input id="s" size="80" /> <br />
    <textarea cols="80" rows="10"></textarea>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script>
    $(function() {
        $("#s").keyup(function() {
            var s = $(this).val();
            var url = "http://commons.wikimedia.org/w/api.php?action=opensearch&format=json&callback=?&search=File:" + s;
            $.getJSON(url, function(data) {
                var txt = ""; 
                for (var i in data[1]) {
                    var l = data[1][i] + "\n";
                    l = l.replace(" ", "_");
                    txt += l;
                }
                $("textarea").val(txt);
            });
        });
    });
    </script>
</body>
</html>