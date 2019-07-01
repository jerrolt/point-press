require('./bootstrap');

//window.Errors = require('./error-handler.js');
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
		post:{links:[]}
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
		dateDisplay(d){
			var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
			return months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
		},	
		fullname(journalist){
			let fname = journalist.firstname.charAt(0).toUpperCase() + journalist.firstname.slice(1).toLowerCase();
			let lname = journalist.lastname.charAt(0).toUpperCase() + journalist.lastname.slice(1).toLowerCase();
			return fname + ' ' + lname;
		},

		loadPosts(){
			axios.get('/admin/posts').then(response => { 
				this.posts = response.data.posts; 
			});
		},	

		initUpdate(id){					
			axios.get('/admin/post/' + id).then(response => {
				this.post = response.data.post;
			});	
			$('#formModal').modal('show');
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
				date_posted: this.today,
				links: []
			}
			$('#formModal').modal('show');
		},
		
		onRemove(key){
			axios.delete('/admin/post/' + this.posts[key].id).then(response => {
				this.posts[key].deleted_at = response.data.post.deleted_at;
			});
		},
		
		onRestore(key){
			axios.post('/admin/post/restore/' + this.posts[key].id).then(response => {
				this.posts[key].deleted_at = response.data.post.deleted_at;
			});
		}
	}
});






