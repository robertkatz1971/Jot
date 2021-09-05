<template>
  <contacts-list endpoint="/api/birthdays/" showBirthday="true"></contacts-list>
</template>

<script>
import ContactsList from '../js/components/ContactsList';
export default {
    name: "ContactsIndex",
    components: {
        ContactsList
    }
}
</script>

<style scoped>

</style>