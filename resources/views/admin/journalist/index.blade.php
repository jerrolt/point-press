@extends('layouts.app')

@section('content')
<div class="container">
           
    <journalist-ul></journalist-ul>
	
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/app.js') }}" defer></script>
@endpush