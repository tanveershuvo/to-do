<template>
  <v-container class="grey lighten-5 text-center" fluid>
    <v-card class="mt-10 text-center"
            max-width="700">
        <ValidationObserver ref="observer" v-slot="{ validate, handleSubmit }">
          <v-form @submit.prevent="handleSubmit(Submit)">
          <h1 >Login Form</h1>
          <v-row>
          <v-col cols="12" sm="6" md="10">
              <div v-if="errorMessage" >
                  <v-alert type="error">
                      {{ errorMessage }}
                  </v-alert>
              </div>
          </v-col>
            <v-col cols="12" sm="6" md="10">
                <ValidationProvider v-slot="{ errors }" name="email" rules="required|email">
                <v-text-field
                  v-model="form.email"
                  :error-messages="errors"
                  label="E-mail"
                  outlined
                  hide-details
                ></v-text-field>
                <span class="red--text" >{{ errors[0] }}</span>
                </ValidationProvider>
            </v-col>
            <v-col cols="12" sm="6" md="10">
                <ValidationProvider v-slot="{ errors }" name="password" rules="required|min:6">
                <v-text-field
                  v-model="form.password"
                  :error-messages="errors"
                  :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="show ? 'text' : 'password'"
                  label="Password"
                  outlined
                  hide-details
                  @click:append="show = !show"
                ></v-text-field>
                <span class="red--text">{{ errors[0] }}</span>
                </ValidationProvider>
            </v-col>
            <v-col cols="12" sm="6" md="10">
              <v-btn color="success" type="submit" class="pa-5" outlined>Log in</v-btn>
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
import User from '../../Helpers/User'

setInteractionMode("eager");

extend("required", {
  ...required,
  message: "{_field_} can not be empty",
});

extend("min", {
  ...min,
  message: "{_field_} must not be less than {length} characters",
});

extend("email", {
  ...email,
  message: "Email must be valid",
});

export default {
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data: () => ({
      show: false,
      errorMessage: null,
    form: {
      email: null,
      password: null,
    },
  }),
    created() {
        if(User.loggedIn()){
            this.$router.push({name:'Home'})
        }
    },
  methods: {
    async Submit() {
        let uri = "api/v1/auth/login";
        axios
            .post(uri, this.form)
            .then((res) => {
                User.responseAfterLogin(res)
                this.$router.push({name:'Home'})
            })
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
};
</script>

