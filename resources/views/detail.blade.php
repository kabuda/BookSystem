@extends('layouts.app')

@section('title','详细信息')

@section('content')
    @include('layouts.partials.banner')
    @include('layouts.partials.user')
    <div class="rightBar"></div>
    <div class="centerBar" id="entering">
        <div class="centerBar_title">
            <h3>广州大学<span>{{ Auth::user()->acddepartment_name }}</span>购买图书（非图书馆经费）验收单</h3>
        </div>
        <div class="serial_number">
            <label class="lbl_font liushuihao">流水号：</label>
            <span class="liushuihao">{{$info->serialNumber}}</span>
        </div>
        <p class="addition" id="addition">注：1、此表经签名、盖章后形成文字材料一式两份（两份都是原件），连同图书送图书馆
            505室宋梦验收（如果有发票和电子小票可以不用带书）。
        </p>
        <p class="addition_second" id="addition_second">2、验收时间：每周二上午和周五上午，其他时间概不受理，不便之处尽请谅解。
        </p>
        <p class="addition_second" id="addition_second">使用部门：<span>{{ Auth::user()->acddepartment_name }}</span></p>
        <table class="book_show">
            <tr>
                <td colspan="4">图书名称</td>
                <td>作者</td>
                <td colspan="2">ISBN</td>
                <td>单价</td>
                <td>数量（册）</td>
                <td colspan="2">金额</td>
            </tr>
            @foreach($booklists as $booklist)
                <tr class="test_content">
                    <td colspan="4">{{ $booklist->book()->book_name }}</td>
                    <td>{{ $booklist->book()->book_author }}</td>
                    <td colspan="2">{{ $booklist->book()->book_isbn }}</td>
                    <td>{{ $booklist->book()->book_price }}</td>
                    <td>{{ $booklist->book()->book_count }}</td>
                    <td colspan="2">{{ $booklist->book()->book_total_price }}</td>
                <!-- <td>{{ $booklist->book()->book_invNum }}</td>
                    <td>{{ $booklist->book()->readStatus() }}</td>
                    <td>{{ $booklist->book()->created_at }}</td> -->
                </tr>
            @endforeach
            <tr>
                <td colspan="4">合 计 金 额 :</td>
                <td colspan="7" class="align">{{ $total }}</td>
            </tr>
            <tr>
                <td colspan="4">合计金额(大写):</td>
                <td colspan="7" class="align">{{ $cny }}</td>
            </tr>
            <tr>
                <td colspan="4">以上购书的发票号</td>
                <td colspan="7" class="align">{{ $invNum }}</td>
            </tr>
        </table>
        <div class="confirm_signup">
            <div class="confirm_leftBar">
                <p>使用经手人签名：</p>
                <p>使用单位验收人签名：</p>
                <p>使用单位盖章：</p>
                <p>日期：</p>
            </div>
            <div class="confirm_rightBar">
                <p>图书馆验收人签名：</p>
                <p>日 &nbsp;&nbsp;&nbsp;期</p>
            </div>
        </div>
    </div>
    @if($info->status == 3)
        <div class="div_btn">
            <input type="button" class="print btn btn-primary btn-sm" value="打印"/>
            <a href="{{ url()->to('excel/export').'/'.$info->serialNumber }}" class="btn btn-warning btn-sm"
               target="_self">导出</a>
        </div>
    @elseif($info->status == 0 || $info->status == 2)
        <div class="div_btn"><a href="{{ url()->to('booklist/').'/'.$info->serialNumber }}"
                                class=" btn btn-success">修改</a></div>
    @endif
@endsection

@push('scripts')
<script src="{{ asset('js/jquery-1.11.1.js') }}"></script>
<script src="{{ asset('js/jquery.jqprint-0.3.js') }}"></script>
<script src="http://www.jq22.com/jquery/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
    $(function ($) {
        $('.print').click(function () {
            $('.centerBar').jqprint();
        });
        $('.leftBar ul li ').mouseover(function () {
            $(this).addClass('active');
            $(this).find("a").css("text-decoration", "none");
        });
        $('.leftBar ul li ').mouseout(function () {
            $(this).removeClass('active');
        });
    })
</script>
@endpush