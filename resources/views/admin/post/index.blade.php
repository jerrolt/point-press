@extends('layouts.app')

@section('content')
<div class="container">
	
	<div class="row justify-content-center">
		<div class="col-md-12">
			<h3 class="text-center">Media Posts</h3>
			<button class="btn btn-link btn-condensed" @click="initCreate()">+ create post</button>
			<table class="table table-sm table-hover">
				<thead>
					<tr class="text-white bg-secondary" >
						<th scope="col">Date</th>
						<th scope="col">Title</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="posts.length == 0" class="text-secondary">
						<th colspan="3" scope="row">No posts available.</th>
					</tr>
					<tr v-if="posts.length > 0" v-for="(post, key) in posts" :class="{'text-danger':post.deleted_at!==null, 'text-secondary':post.deleted_at===null}">
						<th scope="row">@{{post.name}}</th>
						<td></td>
						<td></td>
					</tr>			
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" class="text-center">pagination here</td>
					</tr>
				</tfoot>
			</table>
		</div>
		<post-form :post="post"></post-form>
	</div>
	
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/post-admin.js') }}" defer></script>
@endpush