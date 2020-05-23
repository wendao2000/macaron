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
            <v-data-table :headers="table.headers" :items="projects" :search="table.search">
                <template v-slot:item.index="{ item }">
                    {{ projects.indexOf(item) + 1 }}
                </template>
                <template v-slot:item.is_active="{ item }">
                    <v-simple-checkbox v-model="item.is_active" disabled></v-simple-checkbox>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mx-1" @click="showModal(item)">mdi-pencil</v-icon>
                    <v-icon small class="mx-1" @click="deleteProject(item)">mdi-delete</v-icon>
                </template>
            </v-data-table>
        </v-card>
        <v-dialog v-model="isModalVisible" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ modalEvent }} Project</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col>
                                <v-text-field label="Project Code" required v-model="project.project_code"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-text-field label="Project Name" required v-model="project.project_name"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-switch label="Is Active" v-model="project.is_active"></v-switch>
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
                           @click="modalEvent === 'Add' ? addProject(project) : editProject(project)">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        name: "Project",

        data() {
            return {
                projects: [],
                defaultProject: {
                    id: undefined,
                    project_code: undefined,
                    project_name: undefined,
                    is_active: true,
                },
                project: {
                    id: undefined,
                    project_code: undefined,
                    project_name: undefined,
                    is_active: undefined,
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
                        {text: 'Project Code', value: 'project_code', divider: true},
                        {text: 'Project Name', value: 'project_name', divider: true},
                        {
                            text: 'Is Active',
                            value: 'is_active',
                            align:'center',
                            divider: true,
                            sortable: false,
                            width: 100
                        },
                        {
                            text: 'Actions',
                            value: 'actions',
                            align:'center',
                            divider: true,
                            filterable: false,
                            sortable: false,
                            width: 100
                        },
                    ],
                    search: undefined
                },
                isModalVisible: false,
            }
        },

        created() {
            this.resetForm();
            this.fetchProjects();
        },

        computed: {
            modalEvent() {
                return this.project.id === undefined ? 'Add' : 'Edit'
            },
        },

        methods: {
            fetchProjects() {
                axios.get('api/latest/project/get-list')
                    .then((response) => {
                        this.projects = response.data.data;
                    }, (error) => {
                        console.log(error);
                    });
            },

            addProject(project) {
                axios.post('api/latest/project/add', project)
                .then((response) => {
                    this.fetchProjects()
                }, (error) => {
                    console.log(error)
                });
            },

            editProject(project) {
                axios.put('api/latest/project/edit', project);
            },

            deleteProject(project) {
                if (confirm('Are you sure?')) {
                    axios.delete('api/latest/project/delete', JSON.stringify(project), {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                }
            },

            showModal(project) {
                if (project !== undefined) {
                    this.project = Object.assign({}, project)
                }

                this.isModalVisible = true
            },

            closeModal() {
                this.isModalVisible = false
                this.$nextTick(() => this.resetForm())
            },

            resetForm() {
                this.project = Object.assign({}, this.defaultProject)
            }
        }
    }
</script>

<style scoped>

</style>
