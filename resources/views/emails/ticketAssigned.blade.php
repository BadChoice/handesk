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
        <div style="/*border-bottom:1px solid #efefef;*/ padding-bottom:10px; font-size:12px">
            <span style="color:#d1d1d1"> {{ config('mail.fetch.replyAboveLine') }}</span>
        </div>

        <div>
            <h3> {{ $title }}</h3>
            <b> {{ $ticket->requester->name }}</b>
            <p style="color:gray">
                {{ $ticket->body }}
            </p>
        </div>

        <div style="margin:60px">
            <a href="{{$url}}" style="background-color:#33BC8C; border-radius:4px; padding:10px 20px 10px 20px; color:white; text-decoration:none;" >
                SEE THE TICKET
            </a>
        </div>

        <div style="margin-top:40px">
            Reply to this email or click the link below:<br>
            <a href="{{$url}}">{{ $url }}</a>
        </div>

        <div style="margin-top:40px">
            Powered by Handesk
        </div>

        <span style="color:white">ticket-id:{{$ticket->id}}.</span>
    </body>
</html>