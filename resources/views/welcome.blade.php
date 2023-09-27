@extends('layouts.app')

@section('content')
<div class="content">    
<a href="/store/"><img src="/img/store.png" alt="store logo"/></a>
<p class="mssg">{{ session('mssg') }}</p>
</div>
 @endsection
