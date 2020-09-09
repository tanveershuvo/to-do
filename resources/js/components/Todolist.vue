<template>
    <v-col cols="6" md="6" sm="12">
            <v-card
                color="grey lighten-2"
                fab
            >
                <v-row>
                    <v-col
                        cols="9"
                        md="9"
                    >
                        <v-card-title class="headline mb-2">{{todolist.title}}</v-card-title>
                        <v-card-subtitle>
                            Posted : {{todolist.created_at}}, Updated : {{todolist.updated_at}}
                        </v-card-subtitle>
                    </v-col>
                    <v-col
                        cols="1"
                        md="1"
                    >
                        <v-btn class="mx-6" fab dark small @click="edit" color="cyan">
                            <v-icon dark>mdi-pencil</v-icon>
                        </v-btn>
                        <edittodo></edittodo>
                    </v-col>
                    <v-col
                        cols="1"
                        md="1"
                    >
                        <v-btn class="mx-6" fab dark small @click="destroy" color="red">
                            <v-icon dark>mdi-delete</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>

                <v-card-text class="text-subtitle-2">
                   {{todolist.details}}
                </v-card-text>
            </v-card>
        </v-col>

</template>

<script>
import addtodo from "./AddTodo"
import edittodo from "./EditTodo"
import todoform from "./TodoForm"
import User from "../Helpers/User";

export default {
    components:{addtodo,edittodo,todoform},
    name: "Todolist",
    props:['todolist'],
    methods:{
        async destroy() {
            let uri = "api/v1/destroy/";
            axios
                .delete(uri + this.todolist.id)
                .then((res) => {
                    this.updateRecord(this.todolist.id)
                }).catch((error) => console.log(error.response.data.message)
            )
        },
        updateRecord(id){
            EventBus.$emit('updateAfterDel', id)
        },
        async edit(){
            let uri = "api/v1/get-todo/";
            axios
                .get(uri + this.todolist.id)
                .then((res) => {
                    this.sendData(res.data)
                }).catch((error) => console.log(error.response.data.message)
            )
        },
        sendData(data){
            EventBus.$emit('singleElementData', data)
        }
    }
}
</script>

<style scoped>

</style>
