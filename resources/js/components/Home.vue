<template>

    <v-card
        class="ma-6"
        outlined
        tile
    >

    <v-container>
        <v-row class="py-2">
            <v-col cols="6">
                <h3 class="indigo--text float-left">Welcome {{name}}! </h3>
            </v-col>
            <v-col cols="6">
                <addtodo
                    class="float-right"
                    v-on:updateData="newData"
                ></addtodo>
            </v-col>
        </v-row>
        <v-row>
        <todolist
            v-for="todolist of todolists"
            :key="todolist.id"
            :todolist=todolist
            v-on:updateRecord="delData"
        ></todolist>
        </v-row>
        </v-container>
    </v-card>
</template>

<script>
import User from "../Helpers/User";
import todolist from "./Todolist"
import addtodo from "./AddTodo"

export default {
    name: "home",
    components:{todolist,addtodo},
    data: () => ({
        name: User.name(),
        todolists:{},
    }),

    methods:{
        loginChecker(){
            if (!User.loggedIn()) {
                this.$router.push({name: 'Login'});
            }
        },
        getData(){
            let uri = "api/v1/auth/all-todos/";
            axios
                .get(uri + User.user_id())
                .then((res) => this.todolists = res.data)
                .catch((error) => console.log(error.response.data))
        },
        newData(data){
            this.todolists.unshift(data);
        },
        delData(id){
            let index = this.todolists.findIndex(todolist => todolist.id === id)
            this.todolists.splice(index,1);
        }

    },
    mounted() {
        this.loginChecker()
        this.getData()
    }
}
</script>

<style scoped>

</style>
