<template>
	<div class="modal fade" tabindex="-1" role="dialog" id="formModal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			    <div class="modal-header">                       
			        <h2 class="modal-title" style="font-family:'Comic Sans MS',cursive,sans-serif;">Media Post</h2>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cancel">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
			    <div class="modal-body">
	

				    	
<form @keydown="errors.clear($event.target.name)">	
	<div class="form-row">
		<div class="form-group col-md-6">
			<label class="col-form-label">Date:</label>
			<input class="form-control" :class="{'is-invalid invalid':errors.has('date_posted')}" name="date_posted" v-model="post.date_posted" type="text" placeholder="yyyy-mm-dd">
		</div>
		<div class="form-group col-md-6">
			<label class="col-form-label">Journalist:</label>
			<select class="form-control form-control-sm" v-model="post.journalist_id">
				<option disabled value="-1">Journalist</option>
				<option v-for="(journalist, key) in journalists" :value="journalist.id">{{journalist.firstname+' '+journalist.lastname}}</option>
			</select>
		</div>
	</div>
	
	<div class="form-group">
	    <label class="col-form-label">Title:</label>
	    <input class="form-control" :class="{'is-invalid invalid':errors.has('title')}" name="title" v-model="post.title" type="text" placeholder="Post Title" @blur="generateHref">
	    <small class="form-text text-danger" v-if="errors.has('title')" v-text="errors.get('title')"></small>
	</div>
		
	<div class="form-group">
	    <label class="col-form-label">Href Tag:</label>
	    <input class="form-control" :class="{'is-invalid invalid':errors.has('href')}" name="href" v-model="post.href" type="text" placeholder="Href Tag">
	    <small class="form-text text-danger" v-if="errors.has('href')" v-text="errors.get('href')"></small>
	</div>
							
	<div class="form-group">
		<label class="col-form-label">Content:</label>
	    <textarea class="form-control" v-model="post.content" rows="5"></textarea>
	</div>
	
	<div class="form-group">
		<legend class="col-form-label col-sm-2 pt-0 pl-0">Status:</legend>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" id="pendingStatus" value="pending" v-model="post.status">
			<label class="form-check-label" for="pendingStatus">pending</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" id="approvedStatus" value="approved" v-model="post.status">
			<label class="form-check-label" for="approvedStatus">approved</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" id="disapprovedStatus" value="disapproved" v-model="post.status">
			<label class="form-check-label" for="disapprovedStatus">disapproved</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" id="enabledStatus" value="enabled" v-model="post.status">
			<label class="form-check-label" for="enabledStatus">enabled</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" id="disabledStatus" value="disabled" v-model="post.status">
			<label class="form-check-label" for="disabledStatus">disabled</label>
		</div>
	</div>
		
	<div class="form-row">
		<div class="form-group col-md-6">
	    	<label class="col-form-label font-weight-bold">Likes:</label>
		    <input v-model="post.likes" type="text" class="form-control" size="5" required>
		    <small class="form-text text-danger" v-if="errors.has('likes')" v-text="errors.get('likes')"></small>
	    </div>			    
		<div class="form-group col-md-6">
		    <label for="Dislikes" class="col-form-label font-weight-bold">Dislikes:</label>
			<input id="upDislikes" v-model="post.dislikes" type="text" class="form-control" size="5" required>
			<small class="form-text text-danger" v-if="errors.has('dislikes')" v-text="errors.get('dislikes')"></small>
		</div>
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
		post: {required:true}
	},
	
	data() {
		return {
			errors: new Errors(),
			journalists: []
		}
	},
	
	computed:{

	},
	watch:{
		
	},
	methods:{
		cancel(){
			this.reset();
			$('formModal').modal('hide');
		},
		reset(){
			this.errors = new Errors();
		},
		validate() {
			this.errors = [];
			this.validationErrors = {};
			if(this.post.id !== undefined) {
				this.update();
			} else {
				this.store();
			}
		},
		generateHref(){
			if(this.post.href === ""){
				this.post.href = this.post.title.replace(/[^\w\d\s-]*/g, '').replace(/[\s_]/g, '-').toLowerCase();
			}
		},
		store(){
			console.log(this.post);
			this.reset();				
			$('#formModal').modal('hide');
			Event.$emit('reload');
		},
		
		update(){
			console.log(this.post);
			this.reset();				
			$('#formModal').modal('hide');
			Event.$emit('reload');
		}	
	},
	
	mounted(){
		axios.get('/admin/journalist/all').then(response => { 
			this.journalists = response.data.journalists; 
		});
	}
}
</script>