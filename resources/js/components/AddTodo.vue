<template>
    <v-row justify="center">
        <v-btn
            color="primary"
            @click="dialog=true"
        ><v-icon>mdi-calendar-plus</v-icon> Add new todo
        </v-btn>
        <v-dialog v-model="dialog" max-width="600px">
            <v-card>
                <ValidationObserver ref="observer" v-slot="{ validate, handleSubmit }">
                    <v-form ref="form" name="form" @submit.prevent="handleSubmit(submit)">
                        <v-card-title>
                            <span class="headline">Add New To Do</span>
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
                            <v-btn color="red lighten-1" @click="dialog=false" >Close</v-btn>
                            <v-btn color="green lighten-1" type="submit">Save</v-btn>
                        </v-card-actions>
                    </v-form>
                </ValidationObserver>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>

import {extend, setInteractionMode, ValidationObserver, ValidationProvider} from "vee-validate"
import {max, required} from "vee-validate/dist/rules"
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
        ValidationProvider,
        ValidationObserver
    },
    name: "AddTodo",
    data: () => ({
        dialog: false,
        form:{
            title:null,
            details:null,
            user_id:User.user_id(),
        },
    }),
    methods:{
        async submit() {
            let uri = "api/v1/add-new-todo";
            axios
                .post(uri, this.form)
                .then((res) => {
                    EventBus.$emit('updateAfterAdd', res.data)
                    this.form.title=null
                    this.form.details=null
                    this.dialog = false
                }).catch((error) => console.log(error)
                )
        },
    }
}
</script>

