<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div>
					<h3 class="text-center">Platforms</h3>
					<button class="btn btn-link btn-condensed float-right text-primary" @click="initForm(-1)">add platform</button>
					
					<table class="table table-sm table-hover">
						<thead>
							<tr class="text-white bg-secondary">
							  <th scope="col">#</th>
							  <th scope="col">Platform</th>
							  <th scope="col"></th>
							  <th scope="col"></th>							 
							</tr>
						</thead>
						<tbody>
							<tr v-for="(platform, i) in platforms" :class="isLive(platform)">
								<th scope="row">{{ platform.id }}</th>
								<td>{{ platform.title }}</td>
								<td>
									<a v-if="platform.websites.length > 0" :href="platform.websites[0].url">
									{{ platform.websites[0].name }}
									</a>
								</td>
								<td class="text-right">
									<div class="btn-group btn-group-sm" role="group" aria-label="Platform Actions">
										<button type="button" class="btn btn-link text-primary" @click="initForm(i)">Edit</button><span class="text-secondary">.</span>
										<button class="btn btn-link text-danger" v-if="platform.deleted_at === null" @click="deletePlatform(i)">Delete</button>
										<button class="btn btn-link text-success" v-if="platform.deleted_at !== null" @click="restorePlatform(i)">Restore</button>		   	
									</div>
								</td>
							</tr>
						</tbody>
					</table>	
				</div>
			</div>
		</div>
		
		<div class="modal fade" tabindex="-1" role="dialog" id="formModal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				    <div class="modal-header">                       
				        <h2 class="modal-title">Platform</h2>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="reset">
				        	<span aria-hidden="true">&times;</span>
				        </button>
				    </div>
				    <div class="modal-body">
				    	<platform-form :platform="platform"></platform-form>
				    </div>				    
				    <div class="modal-footer"></div>
				</div>
			</div>
		</div>
		
		
	</div>
</template>

<script>
import {Errors} from '../../error-handler.js';
export default {
	data() {
		return {
			platforms: [],	
			platform: {
				title: '',
				description: ''
			},					
			isUpdating: -1
		}
	},
	
	mounted() {
		this.loadPlatforms();
	},

	methods: {
		isLive(platform){
			return platform.deleted_at !== null ? 'is-light text-danger' : 'is-light text-secondary';
		},
		initForm(i) {
			this.isUpdating = i;	
			this.platform = {
				title: '',
				description: ''
			};		
			if(i > -1) {
				this.platform = _.cloneDeep(this.platforms[this.isUpdating]);
			}
			this.$children[0].$data.errors = new Errors();		
			$("#formModal").modal("show");
		},		
		loadPlatforms() {
			axios.get('/admin/platform/all').then(response => { 
				this.platforms = response.data.platforms; 
			});
		},
		deletePlatform(i){
			axios.delete('/admin/platform/' + this.platforms[i].id)
			.then(response => { 
				this.platforms[i].deleted_at = response.data.platform.deleted_at;
			}); 			
		},
		restorePlatform(i){
			axios.post('/admin/platform/restore/' + this.platforms[i].id)
			.then(response => { 
				this.platforms[i].deleted_at = response.data.platform.deleted_at;
			});
		},
		reset(){
			this.platform = {
				title: '',
				description: ''
			};					
			this.isUpdating = -1;
			this.loadPlatforms();
		}
	}
}
</script>