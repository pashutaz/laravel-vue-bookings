export default {
    data() {
        return {
            status: null,
            errors: null,
        };
    },

    methods: {
        /**
         * Get validation errors for specific field
         *
         * @param {String} field
         * @returns {Array|null}
         */
        getErrorsFor(field) {
            return this.hasValidationErrors && this.errors[field]
                ? this.errors[field]
                : null;
        },
    },

    computed: {
        hasValidationErrors() {
            return 422 === this.status && this.errors !== null;
        },
    }
}
