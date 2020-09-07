<template>

        <v-container>
            <v-card
                class="ma-1 pa-3"
                outlined
                tile
            >
                    <ValidationObserver ref="observer" v-slot="{ validate, handleSubmit }">
                        <v-form @submit.prevent="handleSubmit(Register)">
                        <h1 class="text-center">Sign Up Form</h1>
                            <v-row class="justify-center">
                                <v-col cols="12" sm="6" md="8">
                                    <div v-if="errorMessage">
                                        <v-alert type="error">
                                            {{errorMessage}}
                                        </v-alert>
                                    </div>
                                </v-col>
                                <v-col cols="12" sm="6" md="8">
                                    <ValidationProvider v-slot="{ errors }" name="name" rules="required">
                                        <v-text-field
                                            v-model="form.name"
                                            :error-messages="errors"
                                            label="Name"
                                            required
                                            outlined
                                            hide-details
                                        ></v-text-field>
                                        <span class="red--text">{{ errors[0] }}</span>
                                    </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="6" md="8" >
                                    <ValidationProvider v-slot="{ errors }" name="email" rules="required|email">
                                        <v-text-field
                                            v-model="form.email"
                                            :error-messages="errors"
                                            label="E-mail"
                                            required
                                            outlined
                                            hide-details
                                        ></v-text-field>
                                        <span class="red--text">{{ errors[0] }}</span>

                                    </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="6" md="8" >
                                    <ValidationProvider v-slot="{ errors }" name="password" rules="required||password:@confirm|min:6">
                                        <v-text-field
                                            v-model="form.password"
                                            :error-messages="errors"
                                            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show1 ? 'text' : 'password'"
                                            label="Password"
                                            required
                                            outlined
                                            hide-details
                                            @click:append="show1 = !show1"
                                        ></v-text-field>
                                        <span class="red--text">{{ errors[0] }}</span>
                                    </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="6" md="8" >
                                    <ValidationProvider v-slot="{ errors }" name="confirm" rules="required">
                                        <v-text-field
                                            v-model="form.password_confirmation"
                                            :error-messages="errors"
                                            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show2 ? 'text' : 'password'"
                                            label="Confirm Password"
                                            required
                                            outlined
                                            hide-details
                                            @click:append="show2 = !show2"
                                        ></v-text-field>
                                        <span class="red--text">{{ errors[0] }}</span>
                                    </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="6" md="8">
                                    <v-btn color="primary" class="pa-6" outlined type="submit">Sign up</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
            </ValidationObserver>
            </v-card>
        </v-container>
</template>

<script>
import { required, email, min } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
import User from "../../Helpers/User";

setInteractionMode('eager')

extend('password', {
    params: ['target'],
    validate(value, { target }) {
        return value === target;
    },
    message: 'Password confirmation does not match'
});
extend('required', {
    ...required,
    message: '{_field_} can not be empty',
})

extend('min', {
    ...min,
    message: '{_field_} may not be less than {length} characters',
})

extend('email', {
    ...email,
    message: 'Email must be valid',
})

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
        form:{
            password: '',
            email: '',
            name: '',
            password_confirmation: '',
        },
        errorMessage: null,
        show1: false,
        show2: false,
    }),
    methods: {
        async Register () {
            let uri = "api/v1/auth/signup";
            axios
                .post(uri, this.form)
                .then((res) => User.responseAfterLogin(res))
                .catch((error) =>
                    {
                        let ms;
                        Object.entries(error.response.data.errors).forEach(
                            ([key, value]) => {
                                ms = JSON.stringify(value);
                                this.errorMessage  = ms.replace('[','').replace(']','').replace('"','').replace('"','');
                            }

                        );
                    }
                );
        },
    },
}
</script>
