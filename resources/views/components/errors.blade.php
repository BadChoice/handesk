@if ($errors->any())
    <div class="bg-danger white p3 mt5">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif