<template>
    <v-card
        class="ma-4"
        outlined
        tile
    >
        <v-container>
            <ValidationObserver ref="observer" v-slot="{ validate, reset }">
                <form>
                    <h1 class="my-2">Sign Up Form</h1>
                    <ValidationProvider v-slot="{ errors }" name="name" rules="required">
                        <v-text-field
                            v-model="name"
                            :error-messages="errors"
                            label="Name"
                            required
                            outlined
                        ></v-text-field>
                    </ValidationProvider>
                    <ValidationProvider v-slot="{ errors }" name="email" rules="required|email">
                        <v-text-field
                            v-model="email"
                            :error-messages="errors"
                            label="E-mail"
                            required
                            outlined
                        ></v-text-field>
                    </ValidationProvider>
                    <ValidationProvider v-slot="{ errors }" name="password" rules="required">
                        <v-text-field
                            v-model="password"
                            :error-messages="errors"
                            label="Password"
                            required
                            outlined
                            type="password"
                        ></v-text-field>
                    </ValidationProvider>
                    <ValidationProvider v-slot="{ errors }" name="confirmPassword" rules="required">
                        <v-text-field
                            v-model="confirmPassword"
                            :error-messages="errors"
                            label="Confirm Password"
                            required
                            outlined
                            type="password"
                        ></v-text-field>
                    </ValidationProvider>

                    <v-btn color="primary" outlined class="pa-6" @click="submit">Sign up</v-btn>
                </form>
            </ValidationObserver>
        </v-container>
    </v-card>
</template>

<script>
import { required, email, max } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'

setInteractionMode('eager')

extend('required', {
    ...required,
    message: '{_field_} can not be empty',
})

extend('max', {
    ...max,
    message: '{_field_} may not be greater than {length} characters',
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
        password: '',
        email: '',
        name: '',
        confirmPassword: '',
    }),

    methods: {
        submit () {
            this.$refs.observer.validate()

        },
    },
}
</script>
