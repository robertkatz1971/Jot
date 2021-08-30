<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div v-else>
        <div class="flex justify-between">
            <div class="text-blue-400">
                < Back
            </div>
            <div>
                <router-link :to="/contact/ + contact.id + '/edit'" class="px-4 py-2 rounded text-sm font-bold text-green-500 border border-green-500 mr-2">Edit</router-link> 
                <a href="#" class="px-4 py-2 rounded text-sm font-bold text-red-500 border border-red-500">Delete</a>
            </div>
        </div>   
        <div class="flex items-center pt-6">
            <user-circle :name="contact.name"></user-circle>
            <p class="pl-5 text-xl">{{ contact.name }}</p>
            
        </div>
        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Contact</p>
        <p class="pt-2 text-blue-400">{{ contact.email }}</p>
        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Company</p>
        <p class="pt-2 text-blue-400">{{ contact.company }}</p>
        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Birthday</p>
        <p class="pt-2 text-blue-400">{{ contact.birthday }}</p>
    </div>
  </div>
    
</template>

<script>
import UserCircle from '../js/components/UserCircle.vue'
export default {
    components: {
        UserCircle
    },
    name: "ContactShow",
    data: function() {
        return {
            contact: null,
            loading: true
        }
    },
    mounted() {
        axios.get('/api/contacts/' + this.$route.params.id)
            .then(response => {
                this.contact = response.data.data;
                this.loading = false;
            })
            .catch(errors => {
                this.errors = errors.response.data.errors;
                this.loading = false;
            });

    }
}
</script>

<style>

</style>