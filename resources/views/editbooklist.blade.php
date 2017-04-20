@extends('layouts.app')

@section('title','修改图书列表')

@section('content')
    @include('layouts.partials.banner')
    @include('layouts.partials.user')
    <div class="rightBar"></div>
    <div class="centerBar" id="entering">
        <!-- 修改  -->
        <div class="info_bar">
            <div><p>流水号：<span id="liushuihao">{{ $b->serialNumber }}</span></p></div>
            <div><p>申请人：<span id="aplc">{{ $b->user->name }}</span></p></div>
            <div><p>申请时间：<span id="aplc_time">{{ $b->created_at }}</span></p></div>
        </div>

        <div class="container">
            <button class="btn btn-primary btn-md btn_add" id="btn_add" data-toggle="modal" data-target="#myModal">
                修改图书
            </button>
            <a class="btn btn-primary btn-md btn_add" id="btn_submit" href="{{ url()->to('book/upload') }}">确认图书</a>
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
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="div_control">
                                    <label class="lbl_font">图书名称：</label>
                                    <input id="book_name" name="book_name" type="text" class="required"
                                           data-valid="isNonEmpty||maxLength" value="{{ $b->book_name }}"
                                           maxlength="100"
                                           data-error="图书名称不能为空||最多可输入100个"/></div>
                                <div class="div_control">
                                    <label class="lbl_font">作&nbsp;者：</label>
                                    <input id="book_author" name="book_author" type="text" class="required"
                                           data-valid="isNonEmpty||maxLength" value="{{ $b->book_author }}"
                                           maxlength="100"
                                           data-error="作者名称不能为空||最多可输入100个"/></div>
                                <div class="div_control"><label class="lbl_font">单&nbsp;价：</label>
                                    <input id="book_price" name="book_price" type="text" class="required"
                                           value="{{ $b->book_price }}"
                                           data-valid="isNonEmpty||onlyNum||between:1-8"
                                           data-error="单价不能为空||单价只能为数字||单价长度1-8位"/></div>
                                <div class="div_control"><label class="lbl_font">数&nbsp;量：</label>
                                    <input type="text" name="book_count" id="book_count" class="required"
                                           data-valid="isNonEmpty||onlyNum||between:1-8" value="{{ $b->book_count }}"
                                           data-error="数量不能为空||数量只能为数字||数量长度1-8位"/>
                                </div>
                                <div class="div_control">
                                    <label class="lbl_font">ISBN：</label>
                                    <input id="book_isbn" name="book_isbn" type="text" class="required"
                                           data-valid="isNonEmpty||onlyNum||maxLength" maxlength="13"
                                           value="{{ $b->book_isbn }}"
                                           data-error="ISBN不能为空||ISBN只能是数字||最大长度为13"/>
                                </div>
                                <div class="div_control"><label class="lbl_font">发票号：</label>
                                    <input id="book_invNum" name="book_invNum" type="text" placeholder="多个发票号请用逗号隔开"
                                           class="required" value="{{ $b->book_invNum }}"
                                           data-valid="isNonEmpty||maxLength" maxlength="100"
                                           data-error="发票号不能为空||发票号最大长度为100"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="关闭">
                                <input type="submit" class="btn btn-primary" value="修改"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="transitBar"></div>--}}
        <table class="result_show">
            <tr>
                {{--<td>选择</td>--}}
                <td>序号</td>
                <td>图书名称</td>
                <td>作者</td>
                <td>ISBN</td>
                <td>单价</td>
                <td>数量</td>
                <td>总价</td>
                <td>审核状态</td>
                <td>发票号</td>
                <td>录入时间</td>
                {{--<td>操作</td>--}}
            </tr>
            @foreach($booklists as $booklist)
                <tr class="test_content">
                    {{--<td><input type="checkbox"/></td>--}}
                    <td>1</td>
                    <td>
                        @if($b->id == $booklist->id)
                            {{ $booklist->book()->book_name }}
                        @else
                            <a href="{{ url()->current().'/'.$booklist->id }}">{{ $booklist->book()->book_name }}</a>
                        @endif

                    </td>
                    <td>{{ $booklist->book()->book_author}}</td>
                    <td>{{ $booklist->book()->book_isbn }}</td>
                    <td>{{ $booklist->book()->book_price}}</td>
                    <td>{{ $booklist->book()->book_count}}</td>
                    <td>{{ $booklist->book()->book_total_price}}</td>
                    <td>{{ $booklist->book()->readStatus() }}</td>
                    <td>{{ $booklist->book()->book_invNum }}</td>
                    <td>{{ $booklist->book()->created_at }}</td>
                    {{--<td>--}}
                    {{--@if($b->id == $book->id)--}}

                    {{--@else--}}
                    {{--<a href="{{ url()->current().'/'.$book->id }}">修改</a>--}}
                    {{--@endif--}}

                    {{--</td>--}}
                </tr>
            @endforeach
        </table>
    </div>
@endsection

@push('scripts')

@endpush