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
                        <v-btn class="mx-6" fab dark small color="cyan">
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

                <v-card-text class="text-subtitle-2">
                   {{todolist.details}}
                </v-card-text>
            </v-card>
        </v-col>
</template>

<script>
import addtodo from "./AddTodo";

export default {
    components:{addtodo},
    name: "Todolist",
    props:['todolist'],
    methods:{
        async destroy() {
            let uri = "api/v1/auth/destroy/";
            axios
                .delete(uri + this.todolist.id)
                .then((res) => {
                    this.updateRecord(this.todolist.id)
                }).catch((error) => console.log(error.response.data.message)
            )
        },
        updateRecord(id){
            this.$emit('updateRecord',id)
        },
    }
}
</script>

<style scoped>

</style>
