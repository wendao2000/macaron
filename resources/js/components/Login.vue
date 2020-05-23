<template>
    <div class="container">
        <v-form ref="form" v-model="input.valid" @submit="login">
            <v-text-field
                v-model="input._token"
                v-show="false"
            ></v-text-field>
            <v-text-field
                label="E-Mail Address"
                v-model="input.email"
                append-icon="mdi-email"
                :rules="[input.rules.required]"
                single-line
            ></v-text-field>
            <v-text-field
                label="Password"
                v-model="input.password"
                :append-icon="input.opt.password.show ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[input.rules.required]"
                single-line
                :type="input.opt.password.show ? 'text' : 'password'"
                @click:append="input.opt.password.show = !input.opt.password.show"
            ></v-text-field>
            <v-checkbox
                label="Remember Me"
                v-model="input.remember"
            ></v-checkbox>
            <v-btn class="mr-4" color="primary" @click="login">
                Login
            </v-btn>
            <a class="btn btn-link">Forgot Your Password?</a>
        </v-form>
    </div>
</template>

<script>
    export default {
        name: "Login",

        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

                input: {
                    _token: undefined,
                    email: undefined,
                    password: undefined,
                    remember: undefined,

                    opt: {
                        password: {
                            show: false,
                        }
                    },

                    rules: {
                        required: v => !!v || 'Required.',
                    },

                    valid: false,
                },

                errors: [],
            }
        },

        created() {
            this.input._token = this.csrf
        },

        methods: {
            login() {
                axios.post('login', this.input)
                    .then((response) => {
                        this.$router.push('/');
                    }, (error) => {
                        console.log(error)
                    });
            }
        }
    }
</script>

<style scoped>

</style>
