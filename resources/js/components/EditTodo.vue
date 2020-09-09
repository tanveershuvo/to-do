<template>
    <v-row>
        <v-dialog v-model="dialog" max-width="600px">
            <v-card>
                <todoform :singleTodo="lsingletodo"></todoform>
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
    name: "EditTodo",
    data: () => ({
        lsingletodo: {},
        dialog: false,
    }),
    created(){
        EventBus.$on('addNewTodo',(data) =>{
                //Event on TodoForm Component
                this.Submit(data)
            }
        )
        EventBus.$on('closeModal',() =>{
                //Event on TodoForm Component
                this.dialog = false
            }
        )
        EventBus.$on('singleElementData',(data) =>{
                //Event on TodoForm Component
                this.showData(data)
            }
        )
    },
    methods:{
         showData(data){
            this.lsingletodo = data
            //console.log(this.singleTodo)
            this.dialog = true
        },
        async Submit(data) {
            // let uri = "api/v1/add-new-
            // axios
            //     .post(uri, data)
            //     .then((res) => {
            //         EventBus.$emit('updateAfterAdd', res.data)
            //         EventBus.$emit('resetForm')
            //         this.dialog = false
            //     }).catch((error) => console.log(error)
            // )
        },

    }
}
</script>

