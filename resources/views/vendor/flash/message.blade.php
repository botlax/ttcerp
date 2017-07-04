@if(session('flash_notification'))
<div class="flash-wrap">
@foreach ((array) session('flash_notification') as $message)   
    <div class="flash flash-{{ $message['level'] }} {{ $message['important'] ? 'flash-important' : '' }}">
        @if ($message['important'])
            <button type="button"
                    class="close"
            ><i class="fa fa-close"></i></button>
        @endif

        {!! $message['message'] !!}
    </div>
@endforeach
</div>
@endif
{{ session()->forget('flash_notification') }}
