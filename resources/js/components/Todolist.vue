<template>
    <v-col cols="6" md="6" sm="12">
            <v-card
                color="grey lighten-3"
            >
                <v-row>
                    <v-col
                        cols="9"
                        md="9"
                    >
                        <v-card-text class="headline">{{todolist.title}}</v-card-text>
                        <v-chip class="mx-2"
                                color="primary"
                                outlined
                        >
                            <v-icon>mdi-plus-circle-outline</v-icon> {{todolist.created_at}} <v-icon>mdi-pencil-circle-outline</v-icon>{{todolist.updated_at}}
                        </v-chip>
                    </v-col>
                    <v-col
                        cols="1"
                        md="1"
                    >
                        <v-btn class="mx-6" fab dark small @click="edit(todolist.id)" color="cyan">
                            <v-icon dark>mdi-pencil</v-icon>
                        </v-btn>
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
                <v-card-text class="black--text">
                   {{todolist.details}}
                </v-card-text>
            </v-card>
        </v-col>

</template>

<script>
import addtodo from "./AddTodo"
import todoform from "./TodoForm"
import User from "../Helpers/User";

export default {
    components:{addtodo,todoform},
    name: "Todolist",
    data: () => ({
        editData: null,
    }),
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
         edit(id){
            let uri = "api/v1/get-todo/";
            axios
                .get(uri + id)
                .then((res) => {
                    //propconsole.log(res.data)
                    this.sendData(res.data)
                }).catch((error) => console.log(error.response.data.message)
            )
        },
        sendData(data){
            EventBus.$emit('editFormData', data)
        }
    }
}
</script>

<style scoped>

</style>
