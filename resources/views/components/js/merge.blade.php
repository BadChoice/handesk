<script>
    var mergin = false;
    function onMergePressed(){
        if( ! mergin) {
            return startMergin();
        }
        merge();
    }

    function startMergin(){
        mergin = true;
        $("#mergeButton").removeClass("secondary");
        $("#mergeButton").html("{{__('ticket.mergeDesc')}}");
        $(".selector").show();
    }

    function getSelectedTicketsIds(){
        return $("input[name^=selected]:checked").map(function() {
            return $(this).attr("meta:index");
        }).toArray();
    }

    function merge(){
        var tickets = getSelectedTicketsIds();
        if(tickets.length == 0) return;

        var ticket = prompt("{{__('ticket.mergeDesc2')}}");

        $.post({
            url: "{{ route('tickets.merge.store') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "ticket_id" : ticket,
                "tickets" : tickets
            },
            success: function(){
                location.reload();
            }
        });
    }
</script>