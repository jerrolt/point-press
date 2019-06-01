<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div>
					<h3 class="text-center">Journalists</h3>
					<button class="btn btn-link btn-condensed float-right text-primary" @click="showUpdateModal(-1)">add journalist</button>
					
					<table class="table table-sm table-hover">
						<thead>
							<tr class="text-white bg-secondary">
							  <th scope="col">#</th>
							  <th scope="col">Journalist</th>
							  <th scope="col"></th>
							  <th scope="col"></th>
							  <th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(journalist, i) in journalists" :class="isLive(journalist)">
								<th scope="row">{{ journalist.id }}</th>
								<td>{{ journalist.firstname + " " + journalist.lastname }}</td>
								<td>{{ platforms(journalist) }}</td>
								
								<td>
									<div class="btn-group btn-group-sm" role="group" aria-label="Journalist Actions">
										<button type="button" class="btn btn-link text-primary" @click="showUpdateModal(i)">Edit</button><span class="text-secondary">.</span><button class="btn btn-link text-danger" v-if="journalist.deleted_at === null" @click="deleteJournalist(i)">Delete</button><button class="btn btn-link text-success" v-if="journalist.deleted_at !== null" @click="restoreJournalist(i)">Restore</button>		   	
									</div>
								</td>
								<td>
									<span class="badge badge-primary badge-pill">{{ journalist.posts.length }} posts</span>
								</td>
							</tr>
						</tbody>
					</table>	
				</div>
			</div>
		</div>
		
		<div class="modal fade" tabindex="-1" role="dialog" id="journalistUpdateModal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				    <div class="modal-header">                       
				        <h2 class="modal-title">Journalist</h2>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="reset">
				        	<span aria-hidden="true">&times;</span>
				        </button>
				    </div>
				    <div class="modal-body">			    	
						<journalist-form :journalist="journalist"></journalist-form>
				    </div>
				    
				    <div class="modal-footer">
				    </div>
				</div>
			</div>
		</div>	
	</div>
</template>


<script>
export default {
	data() {
		return {
			journalists: [],	
			journalist: {
				likes: 0,
				dislikes: 0,
				political_party: "independent",
				platforms: []
			},					
			isUpdating: -1
		}
	},
	
	mounted() {
		//load journalists
		this.loadJournalists();
	},

	methods: {
		showUpdateModal(i) {
			this.isUpdating = i;			
			if(i > -1) {
				//copy the object so the list doesn't change with form updates								
				this.journalist = _.cloneDeep(this.journalists[this.isUpdating]);
				this.journalist.platforms = this.journalist.platforms.map(platform => platform.id);
			}						
			$("#journalistUpdateModal").modal("show");
		},
		
		loadJournalists() {
			axios.get('/admin/journalist/all').then(response => { 
				this.journalists = response.data.journalists; 
			});
		},
		
		reset() {
			this.isUpdating = -1;
			this.journalist = {
				likes: 0,
				dislikes: 0,
				political_party: "independent",
				platforms: []
			};
			this.loadJournalists();
		},
		
		deleteJournalist(i) {
			axios.delete('/admin/journalist/' + this.journalists[i].id)
			.then(response => { 
				this.journalists[i].deleted_at = response.data.journalist.deleted_at;
			});            
		},
		
		restoreJournalist(i) {
			axios.post('/admin/journalist/restore/' + this.journalists[i].id)
			.then(response => { 
				this.journalists[i].deleted_at = response.data.journalist.deleted_at;
			});
		},
		
		platforms(journalist) {
			return journalist.platforms.map(platform => platform.title).join(", ");
		},
		
		isLive(journalist){
			return journalist.deleted_at !== null ? 'is-light text-danger' : 'is-light text-secondary';
		},
	}
}
</script>