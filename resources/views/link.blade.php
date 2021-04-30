@extends('layouts.app')

@section('content')
<div class="container">
    <qrcode :link="{{ $link }}" :usd="{{ $usd }}"></qrcode>
</div>
@endsection
