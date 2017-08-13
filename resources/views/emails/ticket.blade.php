<html>
    <head>
        <style>
            @import url('https://fonts.googleapis.com/css?family=Lato:300,500');
            margin:0;
            font-family: Lato,sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            font-weight: 100;
        </style>
    </head>
    <body>
        <div style="border-bottom:1px solid #efefef; padding-bottom:10px;">
            <span style="color:#d1d1d1; font-size:12px"> {{ config('mail.fetch.replyAboveLine') }}</span><br><br>
            <span style="font-size:12px">{{ $title }}</span>
        </div>

        <div style="border-bottom:1px solid #efefef; padding-bottom:10px; margin-left:60px; margin-top:40px;">
            @if(isset($comment))
                <b> {{ $comment->author()->name }}</b><br>
                <span style="color:gray">{{ $comment->created_at->toDateTimeString() }}</span><br>
                <p>
                    {{ $comment->body }}
                </p>
            @else
                <b> {{ $ticket->requester->name }}</b><br>
                <span style="color:gray">{{ $ticket->created_at->toDateTimeString() }}</span><br>
                <p>
                    {{ $ticket->body }}
                </p>
            @endif
        </div>

        <!--div style="margin:60px">
            <a href="{{$url}}" style="background-color:#33BC8C; border-radius:4px; padding:10px 20px 10px 20px; color:white; text-decoration:none;" >
                SEE THE TICKET
            </a>
        </div-->

        <div style="margin-top:40px">
            Add a comment by replying to this email or <a href="{{$url}}">view the ticket in Handesk</a>
        </div>

        <div style="margin-top:40px">
            Powered by Handesk
        </div>

        <span style="color:white">ticket-id:{{$ticket->id}}.</span>
    </body>
</html>