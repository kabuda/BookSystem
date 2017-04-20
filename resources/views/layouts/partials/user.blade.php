<div class="leftBar">
    <h3>{{ Auth::user()->username }}老师,您好！<a href="{{url()->to('/logout')}}">退出</a></h3>
    <ul class="ul_align">
        <li><a href="{{ url()->to('book') }}">图书录入</a></li>
        <li><a href="{{ url()->to('history/all') }}">显示历史申请</a></li>
        @if(Auth::user()->isAdmin())
            <li><a href="{{ url()->to('admin') }}">管理员入口</a></li>
        @endif
    </ul>
</div>
