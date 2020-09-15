<template>
    <v-card
        class="ma-6"
        outlined
        tile
    >
        <v-snackbar
            v-model="snackbar"
            :bottom="true"
            :right="true"
            :timeout="3000"
            :color="color"
        >
            {{ text }}
            <template v-slot:action="{ attrs }">
                <v-btn
                    dark
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>
    <v-container>
        <v-row class="py-2">
            <v-col cols="6">
                <h3 class="indigo--text float-left">Welcome {{name}}! </h3>
            </v-col>
            <v-col cols="6">
                <addtodo class="float-right"></addtodo>
            </v-col>
        </v-row>
        <v-row>
        <todolist
            v-for="todolist of todolists"
            :key="todolist.id"
            :todolist=todolist
        ></todolist>
        </v-row>
        </v-container>
        <edittodo></edittodo>
    </v-card>

</template>

<script>
import User from "../Helpers/User";
import todolist from "./Todolist"
import addtodo from "./AddTodo"
import edittodo from "./EditTodo";
import AppStorage from "../Helpers/AppStorage";
export default {
    name: "home",
    components:{todolist,addtodo, edittodo},
    data: () => ({
        name: User.name(),
        todolists:{},
        editdata:{},
        editModal: false,
        snackbar: false,
        text: null,
        color:null,
    }),
    methods:{
        getData(){
            let uri = "api/v1/all-todos/";
            axios
                .get(uri + User.user_id())
                .then((res) => this.todolists = res.data)
                .catch((error) => console.log(error.response.data))
        },
        notifyUser(text,color){
            this.text = text
            this.color = color
            this.snackbar = true
        },
        updateForm(){
            this.editModal=true;
        },
    },
    created(){
        if (!User.loggedIn()) {
            this.$router.push({name: 'auth'});
        }

        EventBus.$on('updateAfterAdd',(data) =>{
            //Event on AddTodo Component
                this.getData()
                this.notifyUser('Added Successfully','success')
            }
        )
        EventBus.$on('updateAfterUpdate',(data) =>{
                //Event on AddTodo Component
                this.getData()
                this.notifyUser('Edited Successfully','primary')
            }
        )

        EventBus.$on('updateAfterDel',(id) =>{
            //Event on TodoList Component
                this.getData()
                this.notifyUser('Deleted Successfully','red')
            }
        )
        EventBus.$on('editFormData',(data)=>{
            //console.log(data)
            EventBus.$emit('editdata', data)

            }
        )
    },
    mounted(){
        this.getData()
    }
}
</script>

<style scoped>

</style>
