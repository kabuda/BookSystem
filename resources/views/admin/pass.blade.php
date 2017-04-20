@extends('layouts.admin')

@section('title','查看')

@section('content')
    <div class="centerBar" id="entering">

        <div class="div_table ">

            <div class="info_bar">
                <div><p>流水号：<span id="liushuihao">{{ $b->serialNumber }}</span></p></div>
                <div><p>申请人：<span id="aplc">{{ $b->user->username }}</span></p></div>
                <div><p>申请时间：<span id="aplc_time">{{ $b->created_at }}</span></p></div>
            </div>

            <div class="transitBar">
                <table class="result_show table table-hover" id="table1">
                    <tr>
                        <th class="text-center">图书名称</th>
                        <th class="text-center">作者</th>
                        <th class="text-center">单价</th>
                        <th class="text-center">数量</th>
                        <th class="text-center">总价</th>
                        <th class="text-center">ISBN</th>
                        <th class="text-center">发票号</th>
                    </tr>
                    @foreach($booklists as $booklist)
                        <tr class="test_content">
                            <td class="text-center">{{ $booklist->book()->book_name }}</td>
                            <td class="text-center">{{ $booklist->book()->book_author }}</td>
                            <td class="text-center">{{ $booklist->book()->book_price}}</td>
                            <td class="text-center">{{ $booklist->book()->book_count}}</td>
                            <td class="text-center">{{ $booklist->book()->book_total_price}}</td>
                            <td class="text-center">{{ $booklist->book()->book_isbn}}</td>
                            <td class="text-center">{{ $booklist->book()->book_invNum}}</td>
                        </tr>
                    @endforeach
                </table>
                <div class="btn-container">
                <a href="{{ url()->to('admin/checked') }}" class="btn btn-sm btn-primary">返回</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $("tbody tr:gt(0)").click(function () {
        $(this).addClass("info").siblings().removeClass("info");
    });
</script>
@endpush