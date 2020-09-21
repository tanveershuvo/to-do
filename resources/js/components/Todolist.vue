<template>
            <v-flex v-if="todolist.done===0" xs12 sm12 md6 mb-2>
                <v-card color="grey lighten-3" tile>
                    <v-layout row pt-2>
                    <v-flex xs9>
                        <h2 class="mx-3">
                            {{todolist.title}}
                        </h2>
                    </v-flex>
                    <v-flex xs1 mr-1>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    fab
                                    dark
                                    small
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="edit(todolist.id)"
                                    color="cyan">
                                    <v-icon dark>mdi-pencil</v-icon>
                                </v-btn>
                            </template>
                            <span>Edit this todo</span>
                        </v-tooltip>
                    </v-flex>
                    <v-flex xs1>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    fab
                                    dark
                                    small
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="destroy"
                                    color="success">
                                    <v-icon dark>mdi-check</v-icon>
                                </v-btn>
                            </template>
                            <span>Done this todo</span>
                        </v-tooltip>
                    </v-flex>
                    </v-layout>
                    <v-chip class="mx-2"
                            color="primary"
                            outlined
                    >
                        <v-icon>mdi-plus-circle-outline</v-icon> {{todolist.created_at}} <v-icon>mdi-pencil-circle-outline</v-icon>{{todolist.updated_at}}
                    </v-chip>
                    <v-card-text class="black--text">
                        {{todolist.details}}
                    </v-card-text>

                </v-card>
            </v-flex>

            <v-flex v-else xs12 sm12 md6 mb-2>
                <v-card color="green lighten-4" tile>
                    <v-layout row pt-2>
                        <v-flex xs9>
                            <h2 class="mx-3 text-decoration-line-through">
                                {{todolist.title}}
                            </h2>
                        </v-flex>
                        <v-flex xs1 mr-1>
                            <v-tooltip left>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        fab
                                        dark
                                        v-bind="attrs"
                                        v-on="on"
                                        small
                                        @click="edit(todolist.id)"
                                        color="orange">
                                        <v-icon dark>mdi-close</v-icon>
                                    </v-btn>
                                </template>
                                <span>Un-Done this todo</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex xs1>
                            <v-tooltip right>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        fab
                                        dark
                                        small
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="destroy"
                                        color="red">
                                        <v-icon dark>mdi-delete</v-icon>
                                    </v-btn>
                                </template>
                                <span>Delete this todo</span>
                            </v-tooltip>
                        </v-flex>
                    </v-layout>
                    <v-chip class="mx-2"
                            color="primary"
                            outlined
                    >
                        <v-icon>mdi-plus-circle-outline</v-icon> {{todolist.created_at}} <v-icon>mdi-pencil-circle-outline</v-icon>{{todolist.updated_at}}
                    </v-chip>
                    <v-card-text class="black--text text-decoration-line-through">
                        {{todolist.details}}
                    </v-card-text>

                </v-card>
            </v-flex>
</template>

<script>
import addtodo from "./AddTodo"
import User from "../Helpers/User"

export default {
    components:{addtodo},
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
