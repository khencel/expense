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
                    <tr v-if="Object.keys(categories).length == 0">
                        <td class="text-center" colspan="3">No Record...</td>
                    </tr>
                    <tr v-for="category in categories" :key="category.id" @click="editCategoryModal(category.id)">
                        <td>{{category.name}}</td>
                        <td>{{category.description}}</td>
                        <td>{{category.created_at}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-right">
        <button class="btn btn-success" @click="categoryModal">Add Category</button>
    </div>


    <!-- modal -->
    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" v-text="editMode?'Edit Category':'Add Category'"></h5>
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
                <button class="mr-auto btn btn-secondary" v-show="editMode" @click="deleteCategory">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button v-show="!editMode" type="button" class="btn btn-primary" @click="saveCategory">Save</button>
                <button v-show="editMode" type="button" class="btn btn-primary" @click="updateCategory">Update</button>
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
                categories:{},
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
            listOfCategory(){
                axios.get('/api/category/index?api_token='+window.token)
                .then(response => {
                    this.categories = response.data;
                });
            },

            categoryModal(){
                this.editMode = false;
                this.form.name = "";
                this.errors = '';
                this.form.description = "";
                $('#openModal').modal('show');
            },

            saveCategory(){
                axios.post('/api/category/store?api_token='+window.token,this.form)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');  
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
                
            },

            editCategoryModal(id){
                this.editMode = true;
                this.form.id = id;
                this.errors = '';
                axios.get('/api/category/show/'+id+'?api_token='+window.token)
                .then(response => {
                    this.form.name = response.data.name;
                    this.form.description = response.data.description;
                });
                $('#openModal').modal('show');
            },

            updateCategory(){
                axios.put('/api/category/update/'+this.form.id+'?api_token='+window.token,this.form)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
            },

            deleteCategory(){
                axios.get('/api/category/delete/'+this.form.id+'?api_token='+window.token)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');
                });
                
            }
            
        },
        mounted() {
            Fire.$on('loadData', ()=>{
                this.listOfCategory();
            });
            this.listOfCategory();
            console.log('Component mounted.')
        }
    }
</script>
