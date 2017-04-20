@extends('layouts.app')

@section('title','历史申请')

@section('content')
    @include('layouts.partials.banner')
    @include('layouts.partials.user')

    <div class="rightBar"></div>

    <div class="centerBar" id="entering">
        <div class="input_group">
            <label class="lbl_font  filter">筛选条件：</label>
            <div class="radio-inline">
                <label class="lbl_font checkbox-inline">
                    <input type="radio" name="optionsRadios" id="optionsRadios1"/>未审核
                </label>
                <label class="lbl_font checkbox-inline">
                    <input type="radio" name="optionsRadios" id="optionsRadios2"/>已审核
                </label>
            </div>
        </div>
        <table class="result_show table table-hover other_control">
            <tr>
                <td>流水号</td>
                <td>录入人</td>
                <td>录入时间</td>
                <td>审核状态</td>
                <td>操作</td>
            </tr>

            @foreach($booklists as $booklist)
                <tr class="test_content">
                    <td class="text-center">{{ $booklist->serialNumber }}</td>
                    <td class="text-center">{{ $booklist->user->username }}</td>
                    <td class="text-center">{{ $booklist->created_at }}</td>
                    <td class="text-center">{{ $booklist->readStatus() }}</td>
                    <td class="text-center">
                        <a href="{{ url()->to('book/detail').'/'.$booklist->serialNumber }}"
                           class="btn btn-xs btn-info">查看</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    {{--<button class="btn btn-primary btn-sm btn-detail">查看详细</button>--}}
@endsection

@push('scripts')
<script type="text/javascript">
    $(function ($) {
        $('.leftBar ul li').mouseover(function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            $(this).find("a").css("text-decoration", "none");

        });


        $('#optionsRadios1').click(
            function () {
                location.href = '{{ url()->to('/history/unpass') }}';
            }
        );
        $('#optionsRadios2').click(
            function () {
                location.href = '{{ url()->to('/history/pass') }}';
            }
        );
    })
</script>
@endpush