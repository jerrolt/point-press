@extends('layouts.app')

@section('content')
<div class="container">   
	<div class="row">  
	    <div class="col-md-12">
		    
			    <select class="form-control d-inline" v-model.lazy="platformIndex" @change="loadWebsites">
					<option disabled value="-1">Select a Platform</option>
					<option v-for="(platform, key) in platforms" :value="key">@{{platform.title}}</option>
				</select>
	    
				<button v-if="platformIndex > -1" class="btn btn-link btn-condensed d-inline float-right align-bottom" @click="initCreate()">+ add website</button>	
	    
				<table class="table table-sm table-hover">
					<thead>
						<tr class="text-white bg-secondary">
						  <th scope="col">#</th>
						  <th scope="col">Websites</th>
						  <th scope="col"></th>
						  <th scope="col"></th>							 
						</tr>
					</thead>
					<tbody>
						<tr v-if="websites.length === 0">
							<td colspan="4" class="text-secondary">No websites listed.</td>
						</tr>
						<tr v-if="websites.length > 0" v-for="(website, key) in websites" :class="{'text-danger':website.deleted_at!==null, 'text-secondary':website.deleted_at===null}">
							<td>@{{website.id}}</td>
							<td>@{{website.name}}</td>
							<td>@{{website.url}}</td>
							<td class="text-right">
								<div class="btn-group-sm">
									<button class="btn btn-link" @click="initUpdate(website.id)">Edit</button>
									<span class="text-secondary">.</span>
									<button v-if="website.deleted_at===null" class="btn btn-link text-danger" @click="onRemove(key)">Remove</button>
									 <button v-if="website.deleted_at!==null" class="btn btn-link text-success" @click="onRestore(key)">Restore</button>
									 <span class="text-secondary">.</span>
									 <button class="btn btn-link text-danger" @click="onPermanentDelete(key)">Permanent Delete</button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
		    </div>
	    </div>
	    <website-form :website="website"></website-form>
    </div> 
        
    
	
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/website-admin.js') }}" defer></script>
@endpush