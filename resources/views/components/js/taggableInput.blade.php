<script>
    $('#{{$el}}').tagsInput({
        'height': '32px',
        'width': '100%',
        'onAddTag': onAddTag,
        'onRemoveTag': onRemoveTag,
        'placeholderColor': '#bbb',
        'defaultText': "Add...",
    });

    function onAddTag(tag){
        $.post({
            url: "{{route("{$endpoint}.tags.store",$object)}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "tag": tag
            }
        });
    }

    function onRemoveTag(tag){
        $.ajax({
            url: "{{ route("{$endpoint}.tags.store",$object)}}" + "/" + tag,
            method : "DELETE",
            data:{
                "_token" : "{{ csrf_token() }}",
            }
        });
    }
</script>