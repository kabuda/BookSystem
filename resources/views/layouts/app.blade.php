<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>

    <link href="{{asset('bootstrap-3.3.7-dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/motaikuang.css')}}" rel="stylesheet">

    <script src="{{asset('js/jquery-3.1.0.min.js')}}"></script>
    <script src="{{asset('bootstrap-3.3.7-dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery-validate.js')}}"></script>
    @stack('scripts')
</head>
<body>

@yield('content')
<script>
    $(function ($) {
        $(".delete-btn").each(function () {
            $(this).on('click', function () {

                var dataID = $($(this).parents('tr')[0]).attr('data-id');

                $.ajax({
                    url: $($(this).parents("table")[0]).attr('delete-url') + dataID,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        if (data.status == 'success') {
                            var sel = "tr[data-id=" + dataID + "]";
                            $(sel).fadeOut();
                            setTimeout(function () {
                                $(sel).remove();
                            }, 400);
                        } else {
                        }
                    },
                    error: function (data) {
                        console.dir(data);
                    }
                });
            }.bind(this));
        });
        $('.leftBar ul li').mouseover(function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            $(this).find("a").css("text-decoration", "none");
        });
    })
</script>
</body>
</html>