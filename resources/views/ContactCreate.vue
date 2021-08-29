<template>
  <div>
      <form @submit.prevent="submitForm">
          <input-field name="name" label="Name" placeholder="Name" @update:field="form.name = $event" :errors="errors"></input-field>
          <input-field name="email" label="Email" placeholder="Email" @update:field="form.email = $event" :errors="errors"></input-field>
          <input-field name="company" label="Company" placeholder="Company" @update:field="form.company = $event" :errors="errors"></input-field>
          <input-field name="birthday" label="Birthday" placeholder="MM/DD/YYYY" @update:field="form.birthday = $event" :errors="errors"></input-field>
          <div class="flex justify-end">
              <button class="text-red-700 border py-2 px-4 rounded mr-5 hover:bg-red-200">Cancel</button>
              <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Add New Contact</button>
          </div>
      </form>
  </div>
</template>

<script>
import InputField from '../js/components/InputField.vue';
export default {
  components: { InputField },
  name: "ContactCreate",
  data: function() {
      return {
          form: {
              'name': '', 
              'email': '',
              'company': '',
              'birthday': '',
          },
          errors: null,
      }
  },
  methods: {
      submitForm: function() {
          axios.post('/api/contacts', this.form)
            .then(response => {

            })
            .catch(errors => {
                this.errors = errors.response.data.errors;
            });
      }
  }
    
}

</script>

<style scoped>

</style>