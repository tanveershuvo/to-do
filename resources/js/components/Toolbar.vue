<template>
    <v-card
        color="grey lighten-4"
        flat
        height="50px"
        tile
    >
        <v-toolbar dense>
            <v-toolbar-title class="mr-2">
                <router-link tag="span" to="/">
                    Simple to-do
                </router-link>
            </v-toolbar-title>
            <router-link tag="span" to="/">
                <v-btn md class="pa-2" outlined color="black"><v-icon>mdi-home</v-icon> Home</v-btn>
            </router-link>
            <v-spacer></v-spacer>
            <div class="">
                <router-link tag="span" to="/login">
                    <v-btn md class="pa-2" outlined color="indigo"><v-icon>mdi-login</v-icon> Login</v-btn>
                </router-link>
                <router-link tag="span"  to="/signup">
                    <v-btn md class="pa-2" outlined color="success"><v-icon>mdi-account-multiple </v-icon>Sign Up</v-btn>
                </router-link>
            </div>
        </v-toolbar>
    </v-card>
</template>

<script>
export default {
    name: "toolbar"
}
</script>

<style>

</style>
