<html>
<body>
<form action="/mercari/keyword/{{$keyword->id}}" method="post">
    {{ method_field('PUT') }}
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    キーワード:<input type="text" name="keyword" value="{{$keyword->keyword}}"><br/>
    最低価格：<input type="number" name="price_min" value="{{$keyword->price_min}}"><br/>
    最高価格：<input type="number" name="price_max" value="{{$keyword->price_max}}"><br/>
    状態: <select name="switch">
        <option value="1" @if($keyword->switch == 1) selected @endif>ON</option>
        <option value="0" @if($keyword->switch == 0) selected @endif>OFF</option>
    </select>
    <input type="submit">
</form>
</body>
</html>