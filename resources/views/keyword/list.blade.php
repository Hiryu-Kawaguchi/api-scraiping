<html>
<body>
    <a href="/mercari/keyword/create">キーワードを追加する</a>
    <table class="example">
        <thead>
        <tr>
            <th>キーワード</th>
            <th>最低価格</th>
            <th>最高価格</th>
            <th>ON/OFF</th>
            <th>編集</th>
            <th>削除</th>
        </tr>
        </thead>
        <tbody>

            @foreach($keywords as $keyword)
                <tr>
                    <td>{{$keyword->keyword}}</td>
                    <td>{{$keyword->price_min}}</td>
                    <td>{{$keyword->price_max}}</td>
                    @if($keyword->switch == 1)
                        <td>ON</td>
                    @else
                        <td>OFF</td>
                    @endif
                    <td>
                        <form method="GET" action="{{ url('/mercari/keyword/'.$keyword->id.'/edit') }}">
                            <input type="submit" value="編集">
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ url('/mercari/keyword/'.$keyword->id) }}">
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="submit" value="削除">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>