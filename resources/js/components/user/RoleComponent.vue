<template>
<div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Display Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in roles" :key="role.id" @click="editRoleModal(role.id)">
                        <td>{{role.name}}</td>
                        <td>{{role.description}}</td>
                        <td>{{role.created_at}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-right">
        <button class="btn btn-success" @click="roleModal">Add Role</button>
    </div>


    <!-- modal -->
    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" v-text="editMode?'Edit Role':'Add Role'"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        Display Name
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" v-model="form.name" type="text" name="">
                        <span class="text-danger font-italic" v-if="errors.name" v-text="errors.name[0]"></span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        Description
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" v-model="form.description" type="text" name="">
                        <span class="text-danger font-italic" v-if="errors.description" v-text="errors.description[0]"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="mr-auto btn btn-secondary" v-show="editMode & this.form.id != 1" @click="deleteRole">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button v-show="!editMode" type="button" class="btn btn-primary" @click="saveRole">Save</button>
                <button v-show="editMode & this.form.id != 1" type="button" class="btn btn-primary" @click="updateRole">Update</button>
            </div>
            </div>
        </div>
    </div>
</div>

</template>

<script>
    export default {
        data(){
            return{
                roles:{},
                errors:{},
                editMode:false,
                
                form: new Form({
                    id:'',
                    name:'',
                    description:'',
                })
            }
        },
        methods:{
            listOfRole(){
                axios.get('/api/user/role/index?api_token='+window.token)
                .then(response => {
                    this.roles = response.data;
                });
            },

            roleModal(){
                this.editMode = false;
                this.form.name = "";
                this.errors = '';
                this.form.description = "";
                $('#openModal').modal('show');
            },

            saveRole(){
                axios.post('/api/user/role/store?api_token='+window.token,this.form)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');  
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
                
            },

            editRoleModal(id){
                this.editMode = true;
                this.form.id = id;
                this.errors = '';
                axios.get('/api/user/role/show/'+id+'?api_token='+window.token)
                .then(response => {
                    this.form.name = response.data.name;
                    this.form.description = response.data.description;
                });
                $('#openModal').modal('show');
            },

            updateRole(){
                axios.put('/api/user/role/update/'+this.form.id+'?api_token='+window.token,this.form)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
            },

            deleteRole(){
                axios.get('/api/user/role/delete/'+this.form.id+'?api_token='+window.token)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');
                });
                
            }
            
        },
        mounted() {
            Fire.$on('loadData', ()=>{
                this.listOfRole();
            });
            this.listOfRole();
            console.log('Component mounted.')
        }
    }
</script>
