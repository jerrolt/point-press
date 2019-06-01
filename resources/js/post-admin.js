require('./bootstrap');

window.Errors = require('./error-handler.js');
window.Vue = require('vue');
window.Event = new Vue();

Vue.component('post-form', require('./components/admin/PostForm.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    data: {
		posts: [],
		post:{}
    },
    created(){
	    Event.$on('reload', () => {this.loadPosts()});
    },
    mounted(){	    
	    this.loadPosts()
	},
	computed:{
		today(){
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			
			if(dd < 10) {
			    dd = '0' + dd;
			} 
			
			if(mm < 10) {
			    mm = '0' + mm;
			} 
			
			return today.getFullYear() + '-' + mm + '-' + dd;
		}
	},
	methods:{	
		loadPosts(){
			axios.get('/admin/posts').then(response => { 
				this.posts = response.data.posts; 
			});
		},
		initCreate(){
			this.post = {
				journalist_id: -1,
				title: "",
				href: "",
				content: "",
				status: "pending",
				likes: 0,
				dislikes: 0,
				date_posted: this.today				
			}
			$('#formModal').modal('show');
		}
	}
});






