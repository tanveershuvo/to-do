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
                <ValidationObserver ref="observer" v-slot="{ validate, handleSubmit }">
                    <v-form @submit.prevent="handleSubmit(Submit)">
                <v-card-title>
                    <span class="headline">New todo</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form ref="form">
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
                        </v-form>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red lighten-2" @click="dialog = false" >Close</v-btn>
                    <v-btn color="blue lighten-2" type="submit">Save</v-btn>
                </v-card-actions>
                    </v-form>
                </ValidationObserver>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
import { required, max } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
import User from "../Helpers/User"

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
        ValidationObserver,
    },
    name: "AddTodo",
    data: () => ({
        dialog: false,
        form:{
            title:null,
            details:null,
            user_id:User.user_id(),
        }
    }),
    methods:{
        async Submit() {
            let uri = "api/v1/auth/add-new-todo";
            axios
                .post(uri, this.form)
                .then((res) => {
                    this.updateData(res.data)
                    this.dialog = false
                    this.$refs.form.reset()
                }).catch((error) => console.log(error.response.data.message)
                )
        },
        updateData(data){
            this.$emit('updateData', data)
        },
    }
}
</script>

<style scoped>

</style>
