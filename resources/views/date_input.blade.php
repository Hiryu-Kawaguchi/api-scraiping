<html>
<body>
<form action="/api/get/list" method="get">
    開始日付：<input type="date" name="start_date"><br/>
    終了日付：<input type="date" name="end_date"><br/>
    タイプの指定: <select name="type">
                    <option value="updated_at ">updated_at</option>
                    <option value="created_at">created_at</option>
                    <option value="test">test</option>
                </select>
    <input type="submit">
</form>
</body>
</html>