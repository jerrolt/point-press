export class Errors {
    /**
     * Create a new Errors instance.
     */
    constructor() {
        this.errors = {};
    }

    /**
     * Determine if an errors exists for the given field.
     *
     * @param {string} field
     */
    has(field,index) {
	    if(index !== undefined)
	    {
		    if(this.errors.hasOwnProperty(field))
		    {
				return this.errors[field].hasOwnProperty(index);
			}
			return false;
	    }
        return this.errors.hasOwnProperty(field);
    }

    /**
     * Determine if we have any errors.
     */
    any() {
        return Object.keys(this.errors).length > 0;
    }

    /**
     * Retrieve the error message for a field.
     *
     * @param {string} field
     */
    get(field,index) {
	    if(index !== undefined)
	    {
		    if (this.errors[field][index]) 
		    {
            	return this.errors[field][index];
        	}
	    }
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }
	
    /**
     * Record the new errors.
     *
     * @param {object} errors
     */
    record(errors) {
	    console.log("Errors:");
	    console.log(errors);
        this.errors = errors;
    }

    /**
     * Clear one or all error fields.
     *
     * @param {string|null} field
     */
    clear(field) {
        if (field) {
            delete this.errors[field];

            return;
        }

        this.errors = {};
    }
}


