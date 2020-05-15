<template>
<div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                 <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Created at</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id" @click="editUserModal(user.id)">
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.role.name}}</td>
                        <td>{{user.created_at}}</td>
                    </tr>
                   
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-right">
        <button class="btn btn-success" @click="userModal">Add User</button>
    </div>


    <!-- modal -->
    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" v-text="editMode?'Edit User':'Add User'"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        Name
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" v-model="form.name" type="text" name="">
                        <span class="text-danger font-italic" v-if="errors.name" v-text="errors.name[0]"></span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        Email Address
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" v-model="form.email" type="email" name="">
                        <span class="text-danger font-italic" v-if="errors.email" v-text="errors.email[0]"></span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        Role
                    </div>
                    <div class="col-md-8">
                        <select name="" id="" v-model="form.role_id" class="form-control">
                            <option value="" disabled hidden>Select Role</option>
                            <option v-for="role in roles" :key="role.id" :value="role.id">
                                {{role.name}}
                            </option>
                        </select>
                        <span class="text-danger font-italic" v-if="errors.role_id" v-text="errors.role_id[0]"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="mr-auto btn btn-secondary" v-show="editMode & this.form.role_id != 1" @click="deleteUser">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button v-show="!editMode" type="button" class="btn btn-primary" @click="saveUser">Save</button>
                <button v-show="editMode & this.form.role_id != 1" type="button" class="btn btn-primary" @click="updateUser">Update</button>
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
                users:{},
                errors:{},
                editMode:false,
                roles:{},
                form: new Form({
                    id:'',
                    name:'',
                    email:'',
                    role_id:'',
                })
            }
        },
        methods:{
            listOfUser(){
                axios.get('/api/user/index?api_token='+window.token)
                .then(response => {
                    this.users = response.data;
                });
            },

            userModal(){
                this.editMode = false;
                this.form.name = "";
                this.form.email = "";
                this.form.role_id = "";
                this.errors = '';
                this.fetchRole();
                $('#openModal').modal('show');
            },

            saveUser(){
                axios.post('/api/user/store?api_token='+window.token,this.form)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');  
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
            },

            fetchRole(){
                axios.get('/api/user/role/index?api_token='+window.token)
                .then(response => {
                    this.roles = response.data;
                });
            },

            editUserModal(id){
                this.editMode = true;
                this.form.id = id;
                this.errors = '';
                this.fetchRole();
                axios.get('/api/user/show/'+id+'?api_token='+window.token)
                .then(response => {
                    this.form.name = response.data.name;
                    this.form.email = response.data.email;
                    this.form.role_id = response.data.role_id;
                });
                $('#openModal').modal('show');
            },

            updateUser(){
                axios.put('/api/user/update/'+this.form.id+'?api_token='+window.token,this.form)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
            },

            deleteUser(){
                axios.get('/api/user/delete/'+this.form.id+'?api_token='+window.token)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');
                });
                
            }
            
        },
        mounted() {
            this.listOfUser();
            Fire.$on('loadData', ()=>{
                this.listOfUser();
            });
            console.log('Component mounted.')
        }
    }
</script>
