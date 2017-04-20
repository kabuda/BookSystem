@extends('layouts.admin')

@section('title','未审核')
@section('content')

    <div class="centerBar" id="entering">
        <div class="div_table ">
            <div class="transitBar">
                <table class="result_show table table-hover" id="table1">
                    <tr>
                        {{--<th>序号</th>--}}
                        <th class="text-center">流水号</th>
                        <th class="text-center">提交人</th>
                        <th class="text-center">提交时间</th>
                        <th class="text-center">操作</th>
                    </tr>
                    @foreach($booklists as $booklist)
                        <tr class="test_content" data-serialNumber = "{{ $booklist->serialNumber }}" >
                            {{--<td>1</td>--}}
                            <td class="text-center">{{ $booklist->serialNumber }}</td>
                            <td class="text-center">{{ $booklist->user->username }}</td>
                            <td class="text-center">{{ $booklist->created_at }}</td>
                            {{--<td><input type="submit" class="btn btn-xs btn-info" id="sub_check" value="审核"--}}
                                                            {{--onclick="checking()"/></td>--}}
                            <td class="text-center">
                                <a href="{{ url()->current().'/'.$booklist->serialNumber }}">审核</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $("#table1 tr:gt(0)").click(function () {
        $(this).addClass("info").siblings().removeClass("info");
    });

    function checking() {
        self.location = '{{ url()->current()}}/'+serialNumber;
    }
</script>
@endpush
