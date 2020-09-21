<template>
    <v-container fluid ma-0 pa-0 fill-height>
        <v-navigation-drawer
            v-model="drawer"
            app
        >
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title><v-icon>mdi-account</v-icon> {{name}}</v-list-item-title>
                </v-list-item-content>
                <v-btn justify-end shrink text small @click.stop="drawer = !drawer" >
                    <v-icon color="red">mdi-close</v-icon>
                </v-btn>
            </v-list-item>
            <v-divider></v-divider>
            <v-list>
                <v-list-item
                v-for="item in items"
                :key="item.title"
                :to="item.to"
                v-if="item.show"
                link
                class="ma-2"
            >
                <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            </v-list>
        </v-navigation-drawer>
            <v-toolbar color="grey lighten-3" class="px-md-15" >
                <v-app-bar-nav-icon @click.stop="drawer = !drawer" class="hidden-md-and-up" ></v-app-bar-nav-icon>
                <v-toolbar-title>
                    Simple to-do
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <div class="hidden-sm-and-down">
                    <span class="mx-2" v-if="name"><v-icon>mdi-account</v-icon> {{name}}</span>
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


    </v-container>


</template>

<script>
import User from "../../Helpers/User";
import Home from "../Home";
export default {
    name: "toolbar",
    data(){
        return {
            drawer: false,
            name: User.name(),
            items:[
                { title:'Home',to:'/home', icon: 'mdi-view-dashboard',show:User.loggedIn()},
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
