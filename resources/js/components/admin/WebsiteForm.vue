<template>
	<div class="modal fade" tabindex="-1" role="dialog" id="formModal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			    <div class="modal-header">                       
			        <h2 class="modal-title">Website</h2>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cancel">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
			    <div class="modal-body">
	

				    	
<form @keydown="errors.clear($event.target.name)">	
	<div class="form-group">
	    <label>Name:</label>
	    <input class="form-control" :class="{'is-invalid invalid':errors.has('name')}" name="name" v-model="website.name" type="text" placeholder="Name">
	    <small class="form-text text-danger" v-if="errors.has('name')" v-text="errors.get('name')"></small>
	</div>
	<div class="form-group">
	    <label>URL:</label>
	    <input class="form-control" :class="{'is-invalid invalid':errors.has('url')}" name="url" v-model="website.url" type="text"  placeholder="URL">
	    <small class="form-text text-danger" v-if="errors.has('url')" v-text="errors.get('url')"></small>
	</div>						
	<div class="form-group">
		<label >Description:</label>
	    <textarea class="form-control" v-model="website.description" rows="3"></textarea>
	</div>
	<div class="form-group">
		<div class="btn-group float-right">
		<button type="button" class="btn btn-danger" @click="cancel">cancel</button>
		<button type="button" class="btn btn-secondary" @click="validate" :disabled="errors.any()">save</button>
		</div>
	</div>
</form>			    	

		
		    	
			    </div>				    
			    <div class="modal-footer"></div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		website: {required:true}
	},
	data() {
		return {
			errors: new Errors(),
		}
	},
	computed:{
		
	},
	methods:{		
		cancel(){
			this.reset();
			$('#formModal').modal('hide');			
		},
		reset(){
			this.errors = new Errors();
		},
		validate() {
			if(this.website.id !== undefined) {
				this.update();
			} else {
				this.store();
			}
		},
		
		store() {
			axios.post('/admin/website', {
				platform_id: this.website.platform_id,
	            name: this.website.name,
	            url: this.website.url,
	            description: this.website.description	            				
			})
			.then(response => {				
	            this.reset();				
	            $('#formModal').modal('hide');
	            Event.$emit('reload');
			})
			.catch(error => this.errors.record(error.response.data.errors));
		},
		
		update() {
			axios.patch('/admin/website/' + this.website.id, {				
	            platform_id: this.website.platform_id,
	            name: this.website.name,
	            url: this.website.url,
	            description: this.website.description	            
            })
            .then(response => {	  
				this.reset();				
	            $('#formModal').modal('hide');
	            Event.$emit('reload');
            })
            .catch(error => this.errors.record(error.response.data.errors));
		}			
	},
	mounted(){
		
	}
}
</script>