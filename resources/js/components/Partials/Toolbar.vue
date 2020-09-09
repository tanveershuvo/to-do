<template>
    <v-card
        color="blue lighten-4"
        flat
        height="50px"
        tile
    >
        <v-toolbar color="grey lighten-3" dense>
            <v-toolbar-title class="mx-10">
                    Simple to-do
            </v-toolbar-title>

            <v-spacer></v-spacer>
            <div class="">

                <router-link
                    tag="span"
                    v-for="item in items"
                    :key="item.title"
                    :to="item.to"
                    v-if="item.show"
                >
                    <v-btn text>
                        {{item.title}}
                    </v-btn>
                </router-link>
            </div>
        </v-toolbar>
    </v-card>
</template>

<script>
import User from "../../Helpers/User";
import Home from "../Home";
export default {
    name: "toolbar",
    data(){
        return {
            items:[
                { title:'Home',to:'/home',show:User.loggedIn()},
                { title:'Login',to:'/',show:!User.loggedIn()},
                { title:'SignUp',to:'/signup',show:!User.loggedIn()},
                { title:'Logout',to:'/logout',show:User.loggedIn()},
            ]
        }
    },
    created(){
        EventBus.$on('logout',() =>{
            User.logOut()
            }
        )
    }
}
</script>

<style>

</style>
