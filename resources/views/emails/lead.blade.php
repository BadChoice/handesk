@extends('emails.layout')

@section('body')
    <h2>{{ $title }}</h2>
    <table>
        <tr><td>Name:</td><td>       {{ $lead->name }}</td></tr>
        <tr><td>Username:</td><td>   {{ $lead->username }}</td></tr>
        <tr><td>Company:</td><td>    {{ $lead->company }}</td></tr>
        <tr><td>City:</td><td>       {{ $lead->city }}</td></tr>
        <tr><td>Country:</td><td>    {{ $lead->country }}</td></tr>
        <tr><td>Phone:</td><td>      {{ $lead->phone }}</td></tr>
        <tr><td>Email:</td><td>      <a href="mailto:{{$lead->email}}">{{ $lead->email}}</a></td></tr>
        <tr><td>Tags:</td><td>       {{ $lead->tagsString() }}</td></tr>
    </table>

    <br><br>
    <a style="background-color:#33BC8C; color:white; border-radius:4px; padding:4px 10px 4px 10px; text-decoration:none" href="{{route('leads.show',$lead)}}">See Lead</a>
@endsection