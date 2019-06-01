@extends('layouts.app')

@section('content')
<div class="container">           
    <platform></platform>	
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/app.js') }}" defer></script>
@endpush