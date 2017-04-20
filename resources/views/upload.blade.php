@extends('layouts.app')
@section('title','提交书籍')

@section('content')
    @include('layouts.partials.banner')
    @include('layouts.partials.user')
    <div class="rightBar"></div>
    <div class="centerBar" id="entering">
            <table class="result_show">
                <tr>
                    {{--<td>选择</td>--}}
                    <td>图书名称</td>
                    <td>作者</td>
                    <td>ISBN</td>
                    <td>单价</td>
                    <td>数量</td>
                    <td>总价</td>
                    <td>审核状态</td>
                    <td>发票号</td>
                    <td>录入时间</td>
                </tr>
                @foreach($books as $book)
                    <tr class="test_content">
                        {{--<td><input type="checkbox"/></td>--}}
                        <td><a href="{{ url()->current().'/'.$book->id }}">{{ $book->book_name }}</a></td>
                        <td>{{$book->book_author}}</td>
                        <td>{{ $book->book_isbn }}</td>
                        <td>{{$book->book_price}}</td>
                        <td>{{$book->book_count}}</td>
                        <td>{{$book->book_total_price}}</td>
                        <td>{{ $book->readStatus() }}</td>
                        <td>{{ $book->book_invNum }}</td>
                        <td>{{ $book->created_at }}</td>
                    </tr>
                @endforeach
            </table>
        <form id="book_submit" action="" method="post">
         <input type="submit" value="提交图书" class="form_submit btn btn-success"/>
                {{ csrf_field() }}

            </form>
    </div>
@endsection

@push('scripts')
<script>
  $(function($){
    $('#book_submit').submit(function (){
        alert("提交图书成功!");
       });
    });
</script>
@endpush