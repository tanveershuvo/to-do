<template>
    <v-card
        class="ma-6"
        outlined
        tile
    >
        <v-snackbar
            v-model="snackbar"
            :bottom="bottom"
            :right="right"
            :timeout="timeout"
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
export default {
    name: "home",
    components:{todolist,addtodo, edittodo},
    data: () => ({
        name: User.name(),
        todolists:{},
        editdata:{},
        editModal: false,
        snackbar: false,
        timeout: 3000,
        bottom: true,
        right: true,
        text: null,
        color:null,
    }),
    methods:{
        updateForm(){
            this.editModal=true;
        },
         updatedData(data){
            this.todolists.unshift(data)
            this.snackbar = true

         },
         delData(id){
            let index = this.todolists.findIndex(todolist => todolist.id === id)
            this.todolists.splice(index,1)
             this.snackbar = true

         }
    },
    created(){
        if (!User.loggedIn()) {
            this.$router.push({name: 'auth'});
        }
        let uri = "api/v1/all-todos/";
        axios
            .get(uri + User.user_id())
            .then((res) => this.todolists = res.data)
            .catch((error) => console.log(error.response.data))

        EventBus.$on('updateAfterAdd',(data) =>{
            //Event on AddTodo Component
                this.updatedData(data)
                this.text = 'Added Successfully'
                this.color = 'success'
            }
        )
        EventBus.$on('updateAfterUpdate',(data) =>{
                //Event on AddTodo Componen
                this.delData(data.id)
                this.updatedData(data)
                this.text = 'Edited Successfully'
                this.color = 'primary'
            }
        )

        EventBus.$on('updateAfterDel',(id) =>{
            //Event on TodoList Component
                this.delData(id)
                this.text = 'Deleted Successfully'
                this.color = 'red'
            }
        )
        EventBus.$on('editFormData',(data)=>{
            //console.log(data)
            EventBus.$emit('editdata', data)

            }
        )
    },

}
</script>

<style scoped>

</style>
