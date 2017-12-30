<html>
<body>
<form action="/mercari/keyword" method="post">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    キーワード:<input type="text" name="keyword"><br/>
    最低価格：<input type="number" name="price_min"><br/>
    最高価格：<input type="number" name="price_max"><br/>
    状態: <select name="switch">
        <option value="1">ON</option>
        <option value="0">OFF</option>
    </select>
    <input type="submit">
</form>
</body>
</html>