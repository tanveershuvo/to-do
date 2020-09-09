<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="primary"
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-icon>mdi-calendar-plus</v-icon> Add new todo
                </v-btn>
            </template>
            <v-card>
                <todoform></todoform>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>

import todoform from "./TodoForm";
import User from "../Helpers/User";

export default {
    components: {
        todoform
    },
    name: "AddTodo",
    data: () => ({
        dialog: false,
    }),
    created(){
        EventBus.$on('addNewTodo',(data) =>{
                //Event on TodoForm Component
                this.Submit(data)
            }
        )
        EventBus.$on('closeModal',(data) =>{
                //Event on TodoForm Component
                this.dialog = false
            }
        )
    },
    methods:{
        async Submit(data) {
            let uri = "api/v1/add-new-todo";
            axios
                .post(uri, data)
                .then((res) => {
                    EventBus.$emit('updateAfterAdd', res.data)
                    EventBus.$emit('resetForm')
                    this.dialog = false
                }).catch((error) => console.log(error)
                )
        },
    }
}
</script>

