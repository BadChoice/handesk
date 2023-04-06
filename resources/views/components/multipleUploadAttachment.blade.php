<table style="width: 100px;" id="attachment-tb">
    <tr id="attachment-primary">
        <td>
            <div>
                {{ Form::file('attachments[]') }}
            </div>
        </td>
        <td>
            <button type="button" style="margin-top: 8px">@icon(plus)</button>
        </td>
    </tr>
</table>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function(){
        $("#attachment-primary td button").on('click', function(){
            $('#attachment-tb').append(`
                <tr class="attacment-secondary">
                    <td>
                        <div>
                            {{ Form::file('attachments[]', ["class" => "attachment"]) }}
                        </div>
                    </td>
                    <td>
                        <button type="button" style="margin-top: 8px" onclick="deleteElement(this)">@icon(minus)</button>
                    </td>
                </tr>
            `);
        });
    });

    const deleteElement = (el) => el.closest('tr').remove();
</script>
