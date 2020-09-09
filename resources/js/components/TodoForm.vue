<template>
    <ValidationObserver ref="observer" v-slot="{ validate, handleSubmit }">
        <v-form ref="form" name="form" @submit.prevent="handleSubmit(Submit)">
            <v-card-title>
                <span class="headline">New todo</span>
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
                <v-btn color="red lighten-2" @click="closeModal">Close</v-btn>
                <v-btn color="blue lighten-2" type="submit">Save</v-btn>
            </v-card-actions>
        </v-form>
    </ValidationObserver>
</template>

<script>
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
    name: "todoform",
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    props:['singleTodo'],
    data: () => ({
        edit: false,
        form:{
            title:null,
            details:null,
            user_id:User.user_id(),
        },
    }),
    created(){
        EventBus.$on('resetForm',() =>{
                //Event on TodoList Component
                this.$refs.form.reset()
            }
        )
        if(this.singleTodo!=null){
            this.form.title = this.singleTodo.title
            this.form.details = this.singleTodo.details
        }


    },
    methods:{
         async Submit(){
             EventBus.$emit('addNewTodo', this.form)
         },
         closeModal(){
            // this.formReset()
            EventBus.$emit('closeModal')
        },
        // formReset(){
        //      this.form.title='';
        //      this.form.details='';
        // }

    }
}
</script>

