<script>
    function getSelectedTicketsIds(){
        return $("input[name^=selected]:checked").map(function() {
            return $(this).attr("meta:index");
        }).toArray();
    }

    function setStatusForMultipleTickets(status){
        var tickets = getSelectedTicketsIds();
        if(tickets.length == 0) return;

        $.post({
            url: "{{ route('tickets.status.update') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "tickets" : tickets,
                "status": status
            },
            success: function(){
                location.reload();
            }
        });
    }
</script>
