<template>
    <div class="relative pb-4">
        <label :for="name" class="text-blue-500 pt-2 uppercase text-xs text-bold absolute">{{ label }}</label>
        <input type="text" :id="name" class="pt-8 w-full border-b pb-2 focus:outline-none focus:border-blue-400 text-gray-900" 
            :placeholder="placeholder" v-model="value" @input="updateField()">
        <p class="text-red-600 text-sm font-bold" v-text="errorMessage()"></p>
    </div>
</template>

<script>
export default {
    name: "InputField",
    props: [
        'name', 'label','placeholder', 'errors'
    ],
    methods: {
        updateField: function() {
            this.clearErrors(this.name);
            this.$emit('update:field', this.value)
        },
        errorMessage: function() {
            if(this.hasError) {
                return this.errors[this.name][0];
            }
            return null;
        },
        clearErrors: function() {

            if (this.hasError) {
                this.errors[this.name] = null;
            }
        },
        
    },
    data: function() {
        return {
            value: ''
        }
    },
    computed: {
        hasError: function() {
            return this.errors && this.errors[this.name] && this.errors[this.name].length > 0
        } 

    }
}
</script>
    
<style scoped>

</style>