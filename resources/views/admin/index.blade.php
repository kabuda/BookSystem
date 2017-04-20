@extends('layouts.admin')

@section('title','后台管理')

@section('content')
    <div class="topBar">
        <div class="div_user">
            管理员{{ Auth::user()->username }}老师，你好！
        </div>
    </div>
    <div class="div_center">
        <div class="leftBar">
            <ul class="ul_align">
                <li><a href="{{ url()->to('admin/unchecked') }}" target="iframe_a">未审核</a></li>
                <li><a href="{{ url()->to('admin/checked') }}" target="iframe_a">已审核</a></li>
            </ul>
        </div>
        <iframe  style="width: 1140px; height: 562px;" name="iframe_a"></iframe>
    </div>
@endsection

@push('scripts')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}"/>
<script>

    function uncheck() {
        $('iframe').attr("src", "{{ url()->to('admin/unchecked') }}");

    }
    function checked() {
        $('iframe').attr("src", "{{ url()->to('admin/checked')}}");

    }

    $(function ($) {

        //导航高亮状态切换
        $('.leftBar li').click(function () {
            $(this).addClass("active").siblings().removeClass("active");
        });


    })
    window.onload = function () {
        $('.leftBar li:first').addClass("active").siblings().removeClass("active");
        $('iframe').attr("src", "{{ url()->to('admin/unchecked') }}");
    };
</script>
@endpush