
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Errors = require('./error-handler.js');

window.Vue = require('vue');
window.Event = new Vue();
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('website-form', require('./components/admin/WebsiteForm.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    data: {
	    platforms: [],
	    websites: [],
	    platformIndex: -1,
	    website: {
		    platform_id: 0,
			name: '',
			url: '',
			description: ''
	    }
    },
    created(){
	    Event.$on('reload', () => {this.loadWebsites()});
    },
    mounted(){
	    axios.get('/admin/platform/all').then(response => { 
			this.platforms = response.data.platforms; 
		});
	},
	methods:{
		loadWebsites(){
			axios.get('/admin/platform/' + this.platforms[this.platformIndex].id + '/websites').then(response => { 
				this.websites = response.data.websites; 
			});
		},
		
		initUpdate(id){					
			axios.get('/admin/website/' + id).then(response => {
				this.website = response.data.website;
			});	
			$('#formModal').modal('show');
		},
		
		initCreate(){			
			this.website = {
			    platform_id: this.platforms[this.platformIndex].id,
				name: '',
				url: '',
				description: ''
		    };
			$('#formModal').modal('show');
		},
		onPermanentDelete(key){
			axios.delete('/admin/website/permanent-delete/' + this.websites[key].id).then(response => {
				this.loadWebsites()
			});
		},
		onRemove(key){
			axios.delete('/admin/website/' + this.websites[key].id).then(response => {
				this.websites[key].deleted_at = response.data.website.deleted_at;
			});
		},
		
		onRestore(key){
			axios.post('/admin/website/restore/' + this.websites[key].id).then(response => {
				this.websites[key].deleted_at = response.data.website.deleted_at;
			});
		}
	}
});
