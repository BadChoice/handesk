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
        if (! '{{ isset($object->id) }}'){
            return;
        }
        $.post({
            url: "{{url("{$endpoint}/" . ($object->id ?? '') . "/tags")}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "tag": tag
            }
        });
    }

    function onRemoveTag(tag){
        if (! '{{ isset($object->id) }}'){
            return;
        }
        $.ajax({
            url: "{{url("{$endpoint}/" . ($object->id ?? '') . "/tags")}}" + '/' + tag,
            method : "DELETE",
            data:{
                "_token" : "{{ csrf_token() }}",
            }
        });
    }
</script>