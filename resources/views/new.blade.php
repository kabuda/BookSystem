@extends('layouts.app')

@section('title','Index')

@section('content')
    @include('layouts.partials.banner')
    @include('layouts.partials.user')
    <div class="rightBar"></div>
    <div class="centerBar" id="entering">
        <<<<<<< HEAD
        <div class="centerBar_title">
            <h3>教师自购类图书登记</h3>
            =======
            <!-- 修改  -->
            <div class="container">
                <button class="btn btn-primary btn-md btn_add" id="btn_add" data-toggle="modal" data-target="#myModal">
                    添加图书
                </button>
                <!-- 模态框（Modal） -->
                <button class="btn btn-primary btn-md btn_add" id="btn_submit">提交图书</button>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">教师自购类图书登记</h4>
                            </div>
                            <form id="book_entering" action="" method="post">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <div class="div_control">
                                        <label class="lbl_font">图书名称：</label>
                                        <input id="book_name" type="text" class="required"
                                               data-valid="isNonEmpty||maxLength" value="" maxlength="100"
                                               data-error="图书名称不能为空||最多可输入100个"/></div>
                                    <div class="div_control">
                                        <label class="lbl_font">作&nbsp;者：</label>
                                        <input id="book_author" type="text" class="required"
                                               data-valid="isNonEmpty||maxLength" value="" maxlength="100"
                                               data-error="作者名称不能为空||最多可输入100个"/></div>
                                    <div class="div_control"><label class="lbl_font">单&nbsp;价：</label>
                                        <input id="book_price" type="text" class="required"
                                               data-valid="isNonEmpty||onlyNum||between:1-8"
                                               data-error="单价不能为空||单价只能为数字||单价长度1-8位"/></div>
                                    <div class="div_control"><label class="lbl_font">数&nbsp;量：</label>
                                        <input type="text" id="book_count" class="required"
                                               data-valid="isNonEmpty||onlyNum||between:1-8"
                                               data-error="数量不能为空||数量只能为数字||数量长度1-8位"/>
                                    </div>
                                    <div class="div_control">
                                        <label class="lbl_font">ISBN：</label>
                                        <input id="book_isbn" type="text" class="required"
                                               data-valid="isNonEmpty||onlyNum||maxLength" maxlength="13"
                                               data-error="ISBN不能为空||ISBN只能是数字||最大长度为13"/></div>
                                    <div class="div_control"><label class="lbl_font">发票号：</label>
                                        <input id="book_invNum" type="text" placeholder="多个发票号请用逗号隔开" class="required"
                                               data-valid="isNonEmpty||maxLength" maxlength="100"
                                               data-error="发票号不能为空||发票号最大长度为100"/></div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-default" data-dismiss="modal" value="关闭">
                                    <input type="submit" class="btn btn-primary" value="加入列表"/>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="centerBar_formBox">
                <form id="book_entering" action="" method="post">
                    {{ csrf_field() }}
                    <div>
                        <label for="book_name" class="item">图书名称：</label>
                        <input type="text" name="book_name" id="book_name" class="required" data-valid="isNonEmpty"
                               data-error="图书名称不能为空"/>
                    </div>
                    <div>
                        <label for="book_author" class="item">作者： </label>
                        <input type="text" name="book_author" id="book_author" class="required" data-valid="isNonEmpty"
                               data-error="作者不能为空">
                    </div>
                    <div>
                        <label for="book_price" class="item">单价： </label>
                        <input type="text" name="book_price" id="book_price" class="required" data-valid="isNonEmpty"
                               data-error="单价不能为空">
                    </div>
                    <div>
                        <label for="book_count" class="item">数量： </label>
                        <input type="text" name="book_count" id="book_count" class="required" data-valid="isNonEmpty"
                               data-error="数量不能为空">
                    </div>
                    <div>
                        <label for="book_isbn" class="item">ISBN: </label>
                        <input type="text" name="book_isbn" id="book_isbn" class="required" data-valid="isNonEmpty"
                               data-error="ISBN不能为空">
                    </div>

                    <div>
                        <label for="book_time" class="item">发票号： </label>
                        <input type="text" name="book_receipt" id="book_receipt" placeholder="多个发票号请用逗号隔开"
                               class="required"
                               data-valid="isNonEmpty" data-error="发票号不能为空"/>
                    </div>
                    <div>
                        <input type="submit" value="加入以下的列表中" class="form_submit"/>
                    </div>
                </form>
                <table class="result_show">
                    <tr>
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
                            <td><a href="{{ url()->current().'/'.$book->id }}">{{ $book->book_name }}</a></td>
                            <td>{{$book->book_author}}</td>
                            <td>{{ $book->book_isbn }}</td>
                            <td>{{$book->book_price}}</td>
                            <td>{{$book->book_count}}</td>
                            <td>{{$book->book_total_price}}</td>
                            <td>未审核</td>
                            <td>{{ $book->book_invNum }}</td>
                            <td>{{ $book->created_at }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        {{--<div class="centerBar" id="entering">--}}
        {{--<!-- 修改  -->--}}

        {{--<form id="book_entering" action="" method="post">--}}
        {{--{{ csrf_field() }}--}}
        {{--<div class="modal-body">--}}
        {{--<div class="div_control">--}}
        {{--<label class="lbl_font">图书名称：</label>--}}
        {{--<input id="book_name" type="text" class="required" data-valid="isNonEmpty||maxLength" value=""--}}
        {{--maxlength="100" data-error="图书名称不能为空||最多可输入100个"/></div>--}}
        {{--<div class="div_control">--}}
        {{--<label class="lbl_font">作&nbsp;者：</label>--}}
        {{--<input id="book_author" type="text" class="required" data-valid="isNonEmpty||maxLength" value=""--}}
        {{--maxlength="100" data-error="作者名称不能为空||最多可输入100个"/></div>--}}
        {{--<div class="div_control"><label class="lbl_font">单&nbsp;价：</label>--}}
        {{--<input id="book_price" type="text" class="required" data-valid="isNonEmpty||onlyNum||between:1-8"--}}
        {{--data-error="单价不能为空||单价只能为数字||单价长度1-8位"/></div>--}}
        {{--<div class="div_quantity"><span><label class="lbl_font"--}}
        {{--style="float: left; padding-top:10px;width: 60px;height: 17px;">数&nbsp;量：</label></span>--}}
        {{--<div class="input-group spinner">--}}
        {{--<input type="text" value="1" id="book_count">--}}
        {{--<div class="input-group-btn-vertical">--}}
        {{--<button class="btn btn-default" type="button"><i class="glyphicon glyphicon-chevron-up"></i>--}}
        {{--</button>--}}
        {{--<button class="btn btn-default" type="button"><i--}}
        {{--class="glyphicon glyphicon-chevron-down"></i></button>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="div_control">--}}
        {{--<label class="lbl_font">ISBN：</label>--}}
        {{--<input id="book_isbn" type="text" class="required" data-valid="isNonEmpty||onlyNum||maxLength"--}}
        {{--maxlength="13" data-error="ISBN不能为空||ISBN只能是数字||最大长度为13"/></div>--}}
        {{--<div class="div_control"><label class="lbl_font">发票号：</label>--}}
        {{--<input id="book_invNum" type="text" placeholder="多个发票号请用逗号隔开" class="required"--}}
        {{--data-valid="isNonEmpty||maxLength" maxlength="100" data-error="发票号不能为空||发票号最大长度为100"/></div>--}}
        {{--</div>--}}
        {{--<div class="modal-footer">--}}
        {{--<input type="submit" class="btn btn-default" data-dismiss="modal" value="关闭">--}}
        {{--<input type="submit" class="btn btn-primary" value="加入列表"/>--}}
        {{--</div>--}}
        {{--</form>--}}


    </div>


@endsection
@push('scripts')
<script src="js/jquery-1.11.1.js"></script>
<script src="js/jquery-validate.js"></script>
<script src="js/jquery.jqprint-0.3.js"></script>
<script src="http://www.jq22.com/jquery/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">

    $(function ($) {
        $('#book_entering').validate({
            type: {
                isChecked: function (value, errorMsg, el) {
                    var i = 0;
                    var $collection = $(el).find('input:checked');
                    if (!$collection.length) {
                        return errorMsg;
                    }
                }
            },
        });
        $('#book_entering').on('submit', function (event) {
            event.preventDefault();
            $(this).validate('submitValidate'); //return true or false;
        });
    });
    $(function ($) {
        $('.print').click(function () {
            $('.result_show').jqprint();
        });
        $('.leftBar ul li ').mouseover(function () {
            $(this).addClass('active');
        });
        $('.leftBar ul li ').mouseout(function () {
            $(this).removeClass('active');
        });

    })
</script>
@endpush







