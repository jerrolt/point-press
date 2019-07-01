<template>
	<form @keydown="errors.clear($event.target.name)">	
    	<div class="form-group">
		    <label for="upTitle">Title:</label>
		    <input id="upTitle" name="title" v-model="platform.title" type="text" :class="invalidTitle" placeholder="Title">
		    <small class="form-text text-danger" v-if="errors.has('title')" v-text="errors.get('title')"></small>
		</div>						
		<div class="form-group">
    		<label for="upDescription">Description:</label>
		    <textarea id="upDescription" class="form-control" v-model="platform.description" rows="3"></textarea>
		</div>
		<div class="form-group">
			<div class="btn-group float-right">
			<button type="button" class="btn btn-danger" @click="cancel">cancel</button>
			<button type="button" class="btn btn-secondary" @click="validate" :disabled="errors.any()">save</button>
			</div>
		</div>
    </form>
</template>

<script>
import {Errors} from '../../error-handler.js';
export default{
	props: {
		platform: {required:true}
	},
	
	data(){
		return {
			errors: new Errors()
		}
	},
	computed: {
		invalidTitle() {
			return this.errors.has('title') ? 'form-control is-invalid invalid' : 'form-control';
		}	
	},
	methods:{
		cancel(){
			$('#formModal').modal('hide');
		},
		validate() {
			this.errors = new Errors();
			if(this.platform.id !== undefined) {
				this.update();
			} else {
				this.store();
			}
		},
		store() {
			axios.post('/admin/platform', {
	            title: this.platform.title,
	            description: this.platform.description	            				
			})
			.then(response => {
				$("#formModal").modal("hide");
	            this.$parent.reset();
			})
			.catch(error => this.errors.record(error.response.data.errors));
		},
		
		update() {
			axios.patch('/admin/platform/' + this.platform.id, {
	            title: this.platform.title,
	            description: this.platform.description	            
            })
            .then(response => {	  
	            $('#formModal').modal('hide');
	            this.$parent.reset();
            })
            .catch(error => this.errors.record(error.response.data.errors));
		}
	}
}
</script>