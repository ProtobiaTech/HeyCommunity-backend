@extends('layouts.home')

@section('content')
    <div class="container pt-4">
        <div class="row">
            <!-- LG 3 -->
            <div class="col-lg-3">
                @include('ucenter._sidebar', ['user' => Auth::user()->user()])
            </div>

            <!-- LG 9 -->
            <div class="col-lg-9">
                @include('ucenter._tabsNav')

                <div class="pt-4">
                    {{--<div class="pull-right">--}}
                        {{--<a href="#" class="btn btn-link" id="mark-all-check">@lang('hc.mark all check')</a>--}}
                    {{--</div>--}}

                    <!-- Notices -->
                    <ul class="list-group">
                        @if($notices->count())
                            @foreach ($notices as $notice)
                                @include('ucenter._notice')
                            @endforeach
                            {!! $notices->render() !!}
                        @else
                            @include('common.nodata')
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>

        var ids = [];

        function checkNotice(id) {
            $.post('/api/notice/check', {'ids': [id]});
            location.reload(true);
        }

        $(document).ready(function () {
            // 全部标记已读
            $('#mark-all-check').on('click', function () {

                $('.list-group-item[style!="color: lightgray"]').each(function () {
                    ids.push($(this).find('.checkbox').val());
                });

                $.ajax({
                    type: 'POST',
                    url: '/api/notice/check',
                    data: {'ids': ids},
                    success: function () {
                        $('.list-group-item').css({color: "lightgray"});
                    }
                });
            });
        });
    </script>
@endsection


