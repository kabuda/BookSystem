@extends('layouts.app')

@section('title','广州大学图书自购录入系统')

@section('content')
    @include('layouts.partials.banner')
    @include('layouts.partials.user')
    <div class="rightBar"></div>
    <div class="centerBar" id="entering">
        <!-- 修改  -->
        <div class="container">
            <button class="btn btn-primary btn-md btn_add" id="btn_add" data-toggle="modal" data-target="#myModal">
                添加图书
            </button>

            @if(!is_null(Auth::user()->getBooks()->first()))
                <a class="btn btn-primary btn-md btn_add" id="btn_submit" href="{{ url()->to('book/upload') }}">确认图书</a>
            @endif

            <div class="btn btn-warning btn-md btn_add" id="import-btn" href="{{ url()->to('book/upload') }}">导入图书</div>

            <div class="download-module">
                <a href="{{ url()->to('excel/template') }}">点击此处下载导入模板</a>
            </div>
            <form action="{{ url()->to('excel/import')}}" enctype="multipart/form-data" class="hidden"
                  method="POST">>
                {!! csrf_field() !!}
                <input class="form-control" id="import" type="file" accept="*/*" name="myfile">
            </form>
            <!-- 模态框（Modal） -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">教师自购类图书登记</h4>
                        </div>
                        <form id="book_entering" action="" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="div_control">
                                    <label class="lbl_font">图书名称：</label>
                                    <input id="book_name" name="book_name" type="text" class="required"
                                           data-valid="isNonEmpty||maxLength" value="" maxlength="100"
                                           data-error="图书名称不能为空||最多可输入100个"/></div>
                                <div class="div_control">
                                    <label class="lbl_font">作&nbsp;者：</label>
                                    <input id="book_author" name="book_author" type="text" class="required"
                                           data-valid="isNonEmpty||maxLength" value="" maxlength="100"
                                           data-error="作者名称不能为空||最多可输入100个"/></div>
                                <div class="div_control"><label class="lbl_font">单&nbsp;价：</label>
                                    <input id="book_price" name="book_price" type="text" class="required"
                                           data-valid="isNonEmpty||onlyNum||between:1-8"
                                           data-error="单价不能为空||单价只能为数字||单价长度1-8位"/></div>
                                <div class="div_control"><label class="lbl_font">数&nbsp;量：</label>
                                    <input type="text" name="book_count" id="book_count" class="required"
                                           data-valid="isNonEmpty||onlyInt||between:1-8"
                                           data-error="数量不能为空||数量只能为正整数||数量长度1-8位"/>
                                </div>
                                <div class="div_control">
                                    <label class="lbl_font">ISBN：</label>
                                    <input id="book_isbn" name="book_isbn" type="text" class="required"
                                           data-valid="isNonEmpty||onlyNum||maxLength" maxlength="13"
                                           data-error="ISBN不能为空||ISBN只能是数字||最大长度为13"/></div>
                                <div class="div_control"><label class="lbl_font">发票号：</label>
                                    <input id="book_invNum" name="book_invNum" type="text" placeholder="多个发票号请用逗号隔开"
                                           class="required"
                                           data-valid="isNonEmpty||maxLength" maxlength="100"
                                           data-error="发票号不能为空||发票号最大长度为100"/></div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="关闭">
                                <input type="submit" class="btn btn-primary" value="加入列表"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class="result_show table table-hover" delete-url="{{ url()->to('book') }}/">
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
                <td>操作</td>
            </tr>

            @foreach($books as $book)
                <tr class="test_content" data-id={{ $book->id }}>
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
                    <td>
                        <a href="{{ url()->current().'/'.$book->id }}"  class="btn btn-primary btn-xs">操作</a>
                        <a href="javascript:;" class="btn btn-danger btn-xs delete-btn">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection


@push('scripts')
<script type="text/javascript">
    $(function ($) {
        $('#book_entering').validate();
        $('#book_entering').on('submit', function (event) {
            $(this).validate('submitValidate');  //return true or false;
            if ($("div .div_control").hasClass("error")) {
                event.preventDefault();
            }

        });

        //左侧导航栏 鼠标移入移出变化


        $("#import-btn").on('click', function () {
            $("#import").click();
        });
        $("#import").on('change', function (ev) {
            var form = $(ev.target).parents("form")[0];
            $(form).submit();
        });
    });

</script>
@endpush