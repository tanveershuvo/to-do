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
                                        v-model="form.title"
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
                                        v-model="form.details"
                                        :error-messages="errors"
                                    ></v-textarea>
                                </ValidationProvider>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="red lighten-2" @click="modal = false" >EClose</v-btn>
                            <v-btn color="blue lighten-2" type="submit">Save</v-btn>
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
    props:{
        editdata:{
            Object
        }
    },
    data: () => ({
        modal: false,
        data:null,
        form:{
            title:null,
            details:null,
            user_id:User.user_id(),
        },
    }),
    created() {
        console.log(this.$props.editdata)
         //this.form.title = this.editdata
    },
    methods:{
        editTodo(){

        }
    }
}
</script>

