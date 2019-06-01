
<body>
	<div id="root" class="container">
		<coupon @applied="onCouponApplied"></coupon>
	</div>
</body>


Vue.component('coupon', {
	template: `<input placeholder="Enter code" @blur="onCouponApplied">`;
	methods: {
		onCouponApplied() {
			this.$emit('applied'); //custom event in parent template
		}
	}
});

new Vue({
	el: '#root',
	methods: {
		onCouponApplied() {
			alert('it was applied');
		}
	}
});


-------------- Communication Between Siblings.Ep 13 ------------------------------

//shared class so both siblings can use listen for an event and emit events
window.Event = new Vue();

Vue.component('coupon', {
	template: `<input placeholder="Enter code" @blur="onCouponApplied">`;
	
	methods: {
		onCouponApplied() {
			Event.$emit('applied'); //custom event in parent template
		}
	}
});

new Vue({
	el: '#root',

	created() {
		Event.$on('applied', () => alert('handling it'));
	}
});


-------------- Named Slots Ep 14 ------------------------------


<body>
	<div id="root" class="container">
		<modal>
			<template slot="header">My title</template>
			
			Content that goes into the body and overrides default body in component.
			
			<template slot="footer">
				<a class="button is-primary">Save Changes</a>
			</template>
		</modal>
	</div>
</body>

//below the footer will only show if <template slot=footer> defined above
Vue.component('modal', {
	template: `
	<div>
		<div class="modal">
			<header class="modal-card-header">
				<slot name="header">Default Title</slot>
			</header>
			
			<section class="modal-card-body">
				<slot>Default body content</slot>
			</section>
			
			<footer class="modal-card-footer" v-if="$slots.footer">
				<slot name="footer"></slot>
			</footer>
		</div>
	</div>
	`
});

-------------- inline-template Ep 19 -----------------------------

OO Forms - create Errors class for handling errors

<form @keydown="errors.clear($event.target.name)">
<span class="help is-danger" v-if="errors.has($event.target.name)" v-text="errors.get('input_name')"></span>

this.$data.errors: new Errors()



-------------------------------------------------------------------------------
<template>
	<form>	
    	<div class="alert alert-danger" v-if="errors.length > 0">
    		<p class="text-center" v-for="error in errors">{{error}}</p>
    	</div>
    	
    	<div class="form-group">
		    <label for="upTitle">Title:</label>
		    <input id="upTitle" v-model="platform.title" type="text" :class="invalidTitle" placeholder="Title">
		    <small v-if="validationErrors.title !== undefined" class="form-text text-danger">{{validationErrors.title[0]}}</small>
		</div>						
		<div class="form-group">
    		<label for="upDescription">Description:</label>
		    <textarea id="upDescription" class="form-control" v-model="platform.description" rows="3"></textarea>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-secondary float-right" @click="validate">save</button>
		</div>
    </form>
</template>

<script>
export default{
	props: {
		platform: {required:true}
	},
	
	data(){
		return {
			errors: [],
			validationErrors: {}
		}
	},
	computed: {
		invalidTitle() {
			return this.validationErrors.title !== undefined ? 'form-control is-invalid invalid' : 'form-control';
		}	
	},
	methods:{
		validate() {
			this.errors = [];
			this.validationErrors = {};
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
			axios.patch('/admin/platform/' + this.platform.id, {
	            title: this.platform.title,
	            description: this.platform.description	            
            })
            .then(response => {	  
	            $('#formModal').modal('hide');
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
	}
}
</script>










