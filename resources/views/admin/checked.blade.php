@extends('layouts.admin')
@section('title','已审核')
@section('content')
<div class="centerBar" id="entering">
    <div class="div_table ">
        <table class="result_show table table-hover" id="table1">
            <tr>
                <th class="text-center">流水号</th>
                <th class="text-center">申请人</th>
                <th class="text-center">审核时间</th>
                <th class="text-center">是否通过</th>
                <th class="text-center">操作</th>
            </tr>
            @foreach($checklists as $checklist)
                <tr class="test_content">
                    <td class="text-center">{{ $checklist->serialNumber }}</td>
                    <td class="text-center">{{ $checklist->applicant->username}}</td>
                    <td class="text-center">{{ $checklist->created_at }}</td>
                    <td class="text-center">{{ $checklist->readStatus() }}</td>
                    <td class="text-center">
                        <a href="{{ url()->to('admin/checked').'/'.$checklist->serialNumber  }}" class="btn btn-xs btn-info" id="sub_look">查看</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
  $(function($){
    $('.result_show tr:gt(0)').click(function () {
        $(this).addClass("info").siblings().removeClass("info");
      });
    });
</script>
@endpush