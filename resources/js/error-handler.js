module.exports = function() {
	this.errors = {};
		
	this.has = function(field){
		return this.errors.hasOwnProperty(field);
	}
	
	this.any = function(){
		return (Object.keys(this.errors).length > 0);
	}
	
	this.get = function(field){
		if(this.errors[field]){
			return this.errors[field][0];
		}		
	}
		
	this.record = function(errors){
		this.errors = errors;
	}
	
	this.clear = function(field){
		//sweet way to delete a property from an object
		delete this.errors[field];  
	}
}