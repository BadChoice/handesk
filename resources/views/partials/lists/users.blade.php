<div class="col-lg-3 col-sm-4">
    <div class="contact-box center-version">
        <a href="{{route('user.profile', ['username' => $list->username])}}">
            <img alt="image" class="img-rounded" src="{{$list->avatar}}">
            <h6 class="mbn"><strong>{{$list->name}}</strong></h6>
            <p>{{$list->username}}</p>
        </a>
    </div>
</div>
