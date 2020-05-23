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
            <v-data-table :headers="table.headers" :items="roles" :search="table.search">
                <template v-slot:item.index="{ item }">
                    {{ roles.indexOf(item) + 1 }}
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mx-1" @click="showModal(item)">mdi-pencil</v-icon>
                    <v-icon small class="mx-1" @click="deleteRole(item)">mdi-delete</v-icon>
                </template>
            </v-data-table>
        </v-card>
        <v-dialog v-model="isModalVisible" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ modalEvent }} Role</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col>
                                <v-text-field label="Role Code *" required v-model="role.role_code"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-text-field label="Role Name *" required v-model="role.role_name"></v-text-field>
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
                           @click="modalEvent === 'Add' ? addRole(role) : editRole(role)">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        name: "Role",

        data() {
            return {
                roles: [],
                defaultRole: {
                    id: '',
                    role_code: '',
                    role_name: '',
                },
                role: {
                    id: '',
                    role_code: '',
                    role_name: '',
                },

                table: {
                    headers: [
                        {
                            text: '#',
                            value: 'index',
                            align:'center',
                            divider: true,
                            sortable: false,
                            width: 50
                        },
                        {text: 'Role Code', value: 'role_code', divider: true},
                        {text: 'Role Name', value: 'role_name', divider: true},
                        {
                            text: 'Actions',
                            value: 'actions',
                            divider: true,
                            sortable: false,
                            width: 100
                        },
                    ],
                    search: ''
                },
                isModalVisible: false,
            }
        },

        created() {
            this.fetchRoles();
        },

        computed: {
            modalEvent() {
                return this.role.id === '' ? 'Add' : 'Edit'
            },
        },

        methods: {
            fetchRoles() {
                axios.get('api/latest/role/get-list')
                    .then((response) => {
                        this.roles = response.data.data;
                    }, (error) => {
                        console.log(error);
                    });
            },

            addRole(role) {
                axios.post('api/latest/role/add', role)
                .then((response) => {
                    this.fetchRoles()
                }, (error) => {
                    console.log(error)
                });
            },

            editRole(role) {
                axios.put('api/latest/role/edit', role);
            },

            deleteRole(role) {
                if (confirm('Are you sure?')) {
                    axios.delete('api/latest/role/delete', JSON.stringify(role), {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                }
            },

            showModal(role) {
                if (role !== undefined) {
                    this.role = Object.assign({}, role)
                }

                this.isModalVisible = true
            },

            closeModal() {
                this.isModalVisible = false
                this.$nextTick(() => this.role = Object.assign({}, this.defaultRole))
            }
        }
    }
</script>

<style scoped>

</style>
