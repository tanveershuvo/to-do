<template>
        <v-container grid-list-md mb-12>
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
            <v-layout justify-end mb-3>
                <v-flex shrink>
                    <addtodo class="pa-2"></addtodo>
                </v-flex>
            </v-layout>
            <v-layout row>
                <todolist
                    v-for="todolist of todolists"
                    :key="todolist.id"
                    :todolist=todolist
                ></todolist>
            </v-layout>
            <edittodo></edittodo>
        </v-container>



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
