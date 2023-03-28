@extends('layouts.exam-conclusion')
@section('title', 'نتیجه آزمون')
@section('content')
<div id="MobileConclusionShow">
    <img src="{{asset('images/result.png')}}">
</div>
<div id="MobileConclusionShowScore">
    امتیاز شما <br> <span>{{$score}}</span>
</div>
<div id="MobileConclusionShowDescription">
    {!!$conclusion->description!!}
</div>
<div id="MobileConclusionShowGoBackButton">
    <a href="{{route('dashboard')}}">{{__('messages.صفحه اصلی')}} </a>
</div>
@endsection
@section('DesktopContent')
<div id="MobileConclusionShow">
    <img src="{{asset('images/result.png')}}">
</div>
<div id="MobileConclusionShowScore">
    امتیاز شما <br> <span>{{$score}}</span>
</div>
<div id="MobileConclusionShowDescription">
    {!!$conclusion->description!!}
</div>
<div id="MobileConclusionShowGoBackButton">
    <a href="{{route('dashboard')}}">{{__('messages.صفحه اصلی')}} </a>
</div>
@endsection