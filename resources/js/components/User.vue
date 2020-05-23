<template>
    <div>
        <v-card>
            <v-card-title>
                <v-text-field
                    v-model="table.search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>
                <v-spacer></v-spacer>
                <v-btn color="primary" class="ma-2" dark @click="showModal()">
                    Add
                </v-btn>
            </v-card-title>
            <v-data-table :headers="table.headers" :items="users" :loading="table.loading" :search="table.search">
                <template v-slot:item.index="{ item }">
                    {{ users.indexOf(item) + 1 }}
                </template>
                <template v-slot:item.roles="{ item }">
                    <v-hover v-slot:default="{ hover }" :close-delay="1000" v-for="role in item.roles" v-bind:key="role.id">
                        <v-chip class="mx-1">
                            <v-expand-x-transition>
                                <div v-if="!hover">
                                    {{ role.role_code }}
                                </div>
                            </v-expand-x-transition>
                            <v-expand-x-transition>
                                <div v-if="hover">
                                    {{ role.role_name }}
                                </div>
                            </v-expand-x-transition>
                        </v-chip>
                    </v-hover>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mx-1" @click="showModal(item)">mdi-pencil</v-icon>
                    <v-icon small class="mx-1" @click="deleteUser(item)">mdi-delete</v-icon>
                </template>
            </v-data-table>
        </v-card>
        <v-dialog v-model="isModalVisible" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ modalEvent }} User</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col>
                                <v-text-field label="Name" required v-model="user.name"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-text-field label="Email" required v-model="user.email"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-select label="Role(s)" required v-model="user.roles" :items="roles"
                                          item-text="role_name" item_value="id" chips multiple return-object></v-select>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>* indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeModal()">
                        Close
                    </v-btn>
                    <v-btn color="blue darken-1" text
                           @click="modalEvent === 'Add' ? addUser(user) : editUser(user)">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        name: "User",

        data() {
            return {
                users: [],
                defaultUser: {
                    id: '',
                    name: '',
                    email: '',
                    roles: [],
                },
                user: {
                    id: '',
                    name: '',
                    email: '',
                    roles: [],
                },

                roles: [],

                table: {
                    headers: [
                        {
                            text: '#',
                            value: 'index',
                            align: 'center',
                            divider: true,
                            sortable: false,
                            width: 50
                        },
                        {text: 'Name', value: 'name', divider: true},
                        {text: 'Email', value: 'email', divider: true},
                        {text: 'Roles', value: 'roles', divider: true},
                        {
                            text: 'Actions',
                            value: 'actions',
                            divider: true,
                            sortable: false,
                            width: 100
                        },
                    ],
                    loading: false,
                    search: ''
                },
                isModalVisible: false,
            }
        },

        created() {
            this.table.loading = true;
            this.fetchUsers();
            this.fetchRoles();
            this.table.loading = false;
        },

        computed: {
            modalEvent() {
                return this.user.id === '' ? 'Add' : 'Edit'
            },
        },

        methods: {
            fetchUsers() {
                axios.get('api/latest/user/get-list')
                    .then((response) => {
                        this.users = response.data.data;
                    }, (error) => {
                        console.log(error);
                    });
            },

            fetchRoles() {
                axios.get('api/latest/role/get-list')
                    .then((response) => {
                        this.roles = response.data.data;
                    }, (error) => {
                        console.log(error);
                    });
            },

            addUser(user) {
                axios.post('api/latest/user/add', user)
                    .then((response) => {
                        this.fetchUsers()
                    }, (error) => {
                        console.log(error)
                    });
            },

            editUser(user) {
                axios.put('api/latest/user/edit', user)
                    .then((response) => {
                        this.fetchUsers()
                    }, (error) => {
                        console.log(error)
                    });
            },

            deleteUser(user) {
                if (confirm('Are you sure?')) {
                    axios.delete('api/latest/user/delete', JSON.stringify(user), {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                }
            },

            showModal(user) {
                if (user !== undefined) {
                    this.user = Object.assign({}, user)
                }

                this.isModalVisible = true
            },

            closeModal() {
                this.isModalVisible = false
                this.$nextTick(() => this.user = Object.assign({}, this.defaultUser))
            },
        }
    }
</script>

<style scoped>

</style>
