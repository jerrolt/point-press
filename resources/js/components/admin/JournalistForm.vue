<template>
	<form>	
    	<div class="alert alert-danger" v-if="errors.length > 0">
    		<p class="text-center" v-for="error in errors">{{error}}</p>
    	</div>												
    	<div class="form-group">	  
			<legend>Media Platforms:</legend>
			<div class="form-check" v-for="platform in platforms">
				<input class="form-check-input" type="checkbox" :value="platform.id" v-model="journalist.platforms">
				<label class="form-check-label">{{platform.title}}</label>
			</div>			
			<span>Platforms: {{journalist.platforms}}</span>
    	</div>						    	
    	<div class="form-row">
    		<legend>Journalist Details:</legend>				    						    			

	    	<div class="form-group col-md-6">
			    <label for="upFirstname">First Name:</label>
			    <input id="upFirstname" v-model="journalist.firstname" type="text" :class="invalidFirstname" placeholder="First Name" required>
			    <small v-if="validationErrors.firstname !== undefined" class="form-text text-danger">{{validationErrors.firstname[0]}}</small>
			</div>																					
			
			<div class="form-group col-md-6">
			    <label for="upLastname">Last Name:</label>
			    <input id="upLastname" v-model="journalist.lastname" type="text" :class="invalidLastname" placeholder="Last Name" required>
			    <small v-if="validationErrors.lastname !== undefined" class="form-text text-danger">{{validationErrors.lastname[0]}}</small>
			</div>
		</div>												
		<div class="form-group">
		    <label for="upTitle">Title:</label>
		    <input id="upTitle" v-model="journalist.title" type="text" :class="invalidTitle" placeholder="Title">
		    <small v-if="validationErrors.title !== undefined" class="form-text text-danger">{{validationErrors.title[0]}}</small>
		</div>						
		<div class="form-group">
    		<label for="upDescription">Description:</label>
		    <textarea id="upDescription" class="form-control" v-model="journalist.description" rows="3"></textarea>
		</div>											
		<div class="form-group">
			<legend>Journalist Ratings:</legend>
			<div class="row">
			    
			    <div class="col-sm-6">
			    	<label for="upLikes" class="col-form-label font-weight-bold">Likes:</label>
				    <input id="upLikes" v-model="journalist.likes" type="text" :class="invalidLikes" size="5" required>
				    <small v-if="validationErrors.likes !== undefined" class="form-text text-danger">{{validationErrors.likes[0]}}</small>
			    </div>
			
			    
			    <div class="col-sm-6">
			    	<label for="upDislikes" class="col-form-label font-weight-bold">Dislikes:</label>
				    <input id="upDislikes" v-model="journalist.dislikes" type="text" :class="invalidDislikes" size="5" required>
				    <small v-if="validationErrors.dislikes !== undefined" class="form-text text-danger">{{validationErrors.dislikes[0]}}</small>
			    </div>
			</div>
		</div>																		
		<div class="form-group">	  
			<legend>Political Party:</legend>
			<div class="form-check">
				<input class="form-check-input" type="radio" v-model="journalist.political_party" id="upPartyIndependent" value="independent">
				<label class="form-check-label" for="upPartyIndependent">Independent</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" v-model="journalist.political_party" id="upPartyRepublican" value="republican">
				<label class="form-check-label" for="upPartyRepublican">Republican</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" v-model="journalist.political_party" id="upPartyDemocrat" value="democrat">
				<label class="form-check-label" for="upPartyDemocrat">Democrat</label>
			</div>							
		</div>						
		<div class="form-group">
			<legend>Social Networkings:</legend>
			<div class="row">
				<label for="upFacebook" class="col-sm-2 col-form-label">Facebook:</label>
			    <div class="col-sm-10">
			      	<input type="text" class="form-control" id="upFacebook" v-model="journalist.facebook" aria-describedby="facebookHelp">
			      	<small id="facebookHelp" class="form-text text-muted"></small>
			    </div>
			</div>
			<div class="row">
				<label for="upTwitter" class="col-sm-2 col-form-label">Twitter:</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="upTwitter" v-model="journalist.twitter" aria-describedby="twitterHelp">
			    	<small id="twitterHelp" class="form-text text-muted"></small>
			    </div>
			</div>
			<div class="row">
				<label for="upInstagram" class="col-sm-2 col-form-label">Instagram:</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="upInstagram" v-model="journalist.instagram" aria-describedby="instagramHelp">
			    	<small id="instagramHelp" class="form-text text-muted"></small>
			    </div>
			</div>
			<div class="row">
				<label for="upYoutube" class="col-sm-2 col-form-label">YouTube:</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="upYoutube" v-model="journalist.youtube" aria-describedby="youtubeHelp">
			    	<small id="youtubeHelp" class="form-text text-muted"></small>
			    </div>
			</div>
			<div class="row">
				<label for="upBitchute" class="col-sm-2 col-form-label">BitChute:</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="upBitchute" v-model="journalist.bitchute" aria-describedby="bitchuteHelp">
			    	<small id="bitchuteHelp" class="form-text text-muted"></small>
			    </div>
			</div>
			<div class="row">
				<label for="upSteemit" class="col-sm-2 col-form-label">Steemit:</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="upSteemit" v-model="journalist.steemit" aria-describedby="steemitHelp">
			    	<small id="steemitHelp" class="form-text text-muted"></small>
			    </div>
			</div>
		</div>
		
		<div class="form-group">
			<button type="button" class="btn btn-secondary float-right" @click="validate">save</button>
		</div>						    	
	</form>			    
</template>

<script>
export default{
	props: {
		journalist: {required:true}
	},
		
	data() {
		return {	
			errors: [],
			validationErrors: {},			
			platforms: []		
		}
	},
	
	computed: {
		invalidFirstname() {
			return this.validationErrors.firstname !== undefined ? 'form-control is-invalid invalid' : 'form-control';
		},		
		invalidLastname() {
			return this.validationErrors.lastname !== undefined ? 'form-control is-invalid invalid' : 'form-control';
		},
		invalidTitle() {
			return this.validationErrors.title !== undefined ? 'form-control is-invalid invalid' : 'form-control';
		},
		invalidLikes() {
			return this.validationErrors.likes !== undefined ? 'form-control w-25 is-invalid invalid' : 'form-control w-25';
		},		
		invalidDislikes() {
			return this.validationErrors.dislikes !== undefined ? 'form-control w-25 is-invalid invalid' : 'form-control w-25';
		}
	},
	
	watch:{

	},
	
	methods: {		
		validate() {
			this.errors = [];
			this.validationErrors = {};
			if(this.journalist.id !== undefined) {
				this.update();
			} else {
				this.store();
			}
		},
		
		store() {
			axios.post('/admin/journalist', {
            	firstname: this.journalist.firstname,
            	lastname: this.journalist.lastname,
	            title: this.journalist.title,
	            description: this.journalist.description,	            
	            political_party: this.journalist.political_party,
	            likes: this.journalist.likes,
	            dislikes: this.journalist.dislikes,	            
	            youtube: this.journalist.youtube,
	            twitter: this.journalist.twitter,
	            facebook: this.journalist.facebook,
	            instagram: this.journalist.instagram,
	            steemit: this.journalist.steemit,
	            bitchute: this.journalist.bitchute,	            
	            platforms: this.journalist.platforms //this.selectedPlatforms				
			})
			.then(response => {
				$('#journalistUpdateModal').modal('hide');
	            this.$parent.reset();
			})
			.catch(error => {
				if(error.response.status === 500) {
		            this.errors.push(error.response.data.message);
	            }
	            if(error.response.status === 422) {
		            this.validationErrors = error.response.data.errors;
		            let keys = [];           
		            (Object.keys(error.response.data.errors)).forEach(key => {
			            keys.push(key)
		            });
		            this.errors.push("Fix validation errors on inputs: " + keys.join(", "));
	            }
			});
		},
		
		update() {
			axios.patch('/admin/journalist/' + this.journalist.id, {
            	firstname: this.journalist.firstname,
            	lastname: this.journalist.lastname,
	            title: this.journalist.title,
	            description: this.journalist.description,	            
	            political_party: this.journalist.political_party,
	            likes: this.journalist.likes,
	            dislikes: this.journalist.dislikes,	            
	            youtube: this.journalist.youtube,
	            twitter: this.journalist.twitter,
	            facebook: this.journalist.facebook,
	            instagram: this.journalist.instagram,
	            steemit: this.journalist.steemit,
	            bitchute: this.journalist.bitchute,	            
	            platforms: this.journalist.platforms //this.selectedPlatforms
            })
            .then(response => {	  
	            $('#journalistUpdateModal').modal('hide');
	            this.$parent.reset();
            })
            .catch(error => {
	            if(error.response.status === 500) {
		            this.errors.push(error.response.data.message);
	            }
	            if(error.response.status === 422) {
		            this.validationErrors = error.response.data.errors;
		            let keys = [];           
		            (Object.keys(error.response.data.errors)).forEach(key => {
			            keys.push(key)
		            });
		            this.errors.push("Fix validation errors on inputs: " + keys.join(", "));
	            }	                         
            });
		}
	},
	
	mounted(){	
		//load all platform choices and check the checkboxes
		axios.get('/admin/platform/all').then(response => { 
			this.platforms = response.data.platforms;
		});			
	}
}
</script>