<template>
    <v-row >

        <v-dialog v-model="modal"  max-width="600px">
            <v-card>
                <ValidationObserver ref="observer" v-slot="{ validate, handleSubmit }">
                    <v-form ref="form" name="form" @submit.prevent="handleSubmit(editTodo)">
                        <v-card-title>
                            <span class="headline">From</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <ValidationProvider v-slot="{ errors }" name="title" rules="required|max:50">
                                    <v-text-field
                                        label="Title *"
                                        outlined
                                        v-model="items.title"
                                        :error-messages="errors"
                                        class="mb-2"
                                    >
                                    </v-text-field>
                                </ValidationProvider>
                                <h1>

                                </h1>
                                <ValidationProvider v-slot="{ errors }" name="details" rules="max:250">
                                    <v-textarea
                                        label="Description"
                                        outlined
                                        rows="4"
                                        row-height="15"
                                        hide-details
                                        v-model="items.details"
                                        :error-messages="errors"
                                    ></v-textarea>
                                </ValidationProvider>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="red lighten-1" @click="modal = false" >Close</v-btn>
                            <v-btn color="blue lighten-1" type="submit">Edit</v-btn>
                        </v-card-actions>
                    </v-form>
                </ValidationObserver>
            </v-card>
        </v-dialog>
    </v-row>

</template>

<script>

import todolist from "./Todolist";
import { required, max } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
import User from "../Helpers/User";

setInteractionMode("eager");

extend("required", {
    ...required,
    message: "{_field_} can not be empty",
});

extend("max", {
    ...max,
    message: "{_field_} must not be more than {length} characters",
});

export default {
    components: {
        todolist,ValidationProvider,
        ValidationObserver,
    },
    name: "EditTodo",
    data: () => ({
        modal: false,
        data:null,
        items:{
            id:null,
            title:null,
            details:null,
            user_id:User.user_id(),
        },
    }),
    created() {
        EventBus.$on('editdata',(data)=>{
            this.items.id = data.id
            this.items.title = data.title
            this.items.details = data.details
            this.modal = true
            }
        )
    },
    methods:{
        editTodo(){
            let uri = "api/v1/update-todo";
            axios
                .post(uri , this.items)
                .then((res) => {
                    this.modal = false
                    EventBus.$emit('updateAfterUpdate',res.data)

                }).catch((error) => console.log(error.response.data)
            )
        }
    }
}
</script>

