
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

//shared class so both siblings can use to listen for an event and emit events
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




--------------- Ep 20 - OO Forms (global form object) -------------











2019_05_03_140923_create_post_website_table.php

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostWebsiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_website', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->unsignedInteger('website_id');
            $table->foreign('website_id')->references('id')->on('websites');
            $table->string('link',100)->nullable(false)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_website');
    }
}















