@extends('layouts.admin')

@section('title','审核图书')

@section('content')
    <div class="centerBar" id="entering">
        <div class="div_table ">
            <div class="info_bar">
                <div><p>流水号：<span id="liushuihao">{{ $b->serialNumber }}</span></p></div>
                <div><p>申请人：<span id="aplc">{{ $b->user->loginNumber }}</span></p></div>
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
                    <form style="float:left;margin-left:400px;margin-right: 30px;" action="{{ url()->to('admin/success').'/'.$b->serialNumber}}" method="post" target="_parent">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-success" id="sub_ok" value="同意"/>
                    </form>
                    <form action="{{ url()->to('admin/error').'/'.$b->serialNumber}}" method="post" target="_parent">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger" id="sub_rfu" value="拒绝"/>
                    </form>
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