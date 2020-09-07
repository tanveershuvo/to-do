<template>
    <v-card
        color="blue lighten-4"
        flat
        height="50px"
        tile
    >
        <v-toolbar color="grey lighten-3" dense>
            <v-toolbar-title class="mx-10">
                <router-link tag="span" to="/">
                    Simple to-do
                </router-link>
            </v-toolbar-title>
            <router-link tag="span" to="/">
                <v-btn text>
                    <v-icon>mdi-home</v-icon>
                    <span>Home</span>
                </v-btn>
            </router-link>
            <v-spacer></v-spacer>
            <div class="">
                <router-link tag="span" to="/login">
                    <v-btn color="indigo" text>
                        <v-icon>mdi-login</v-icon>
                        <span>Log In</span>
                    </v-btn>
                </router-link>
                <router-link tag="span" to="/signup">
                    <v-btn color="success" text>
                        <v-icon>mdi-account-multiple </v-icon>
                        <span>Sign Up</span>
                    </v-btn>
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
