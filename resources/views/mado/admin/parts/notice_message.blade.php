@foreach (NoticeMessage::get() as $message)
    {{-- メッセージのステータスに応じて適用するclassを決定する --}}
    @switch ($message[config('const.common.notice_message.STATUS')])
        @case (config('const.common.notice_message.status.GRAY'))
            <div id="noticeArea" class="borderGray">
            @break
            
        @case (config('const.common.notice_message.status.ORANGE'))
        <div id="noticeArea" class="borderOrange">
            @break

        @default
            <div>
            @break
    @endswitch

        {!! $message[config('const.common.notice_message.MESSAGE')] !!}
    </div>
@endforeach
