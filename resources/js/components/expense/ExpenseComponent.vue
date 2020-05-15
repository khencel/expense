<template>
<div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Expense Category</th>
                        <th>Amount</th>
                        <th>Entry Date</th>
                        <th>Created at</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="Object.keys(expenses).length == 0">
                        <td class="text-center" colspan="4">No Record...</td>
                    </tr>
                    <tr v-for="expense in expenses" :key="expense.id" @click="editExpenseModal(expense.id)">
                        <td>{{expense.category.name}}</td>
                        <td>${{expense.amount}}</td>
                        <td>{{expense.entry_date}}</td>
                        <td>{{expense.created_at}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-right">
        <button class="btn btn-success" @click="expenseModal">Add Expense</button>
    </div>


    <!-- modal -->
    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" v-text="editMode?'Edit Expense':'Add Expense'"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        Expense Category
                    </div>
                    <div class="col-md-8">
                        <select name="" id="" v-model="form.category_id" class="form-control">
                            <option value="" disabled hidden>Select Category</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{category.name}}
                            </option>
                        </select>
                        <span class="text-danger font-italic" v-if="errors.category_id" v-text="errors.category_id[0]"></span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        Amount
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" v-model="form.amount" type="number" name="">
                        <span class="text-danger font-italic" v-if="errors.amount" v-text="errors.amount[0]"></span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        Entry Date
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" v-model="form.entry_date" type="date" name="">
                        <span class="text-danger font-italic" v-if="errors.entry_date" v-text="errors.entry_date[0]"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="mr-auto btn btn-secondary" v-show="editMode" @click="deleteExpenses">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button v-show="!editMode" type="button" class="btn btn-primary" @click="saveCategory">Save</button>
                <button v-show="editMode" type="button" class="btn btn-primary" @click="updateExpenses">Update</button>
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
                expenses:{},
                errors:{},
                editMode:false,
                categories:{},
                form: new Form({
                    id:'',
                    category_id:'',
                    amount:0,
                    entry_date:''
                })
            }
        },
        methods:{
            listOfExpenses(){
                axios.get('/api/expense/index?api_token='+window.token)
                .then(response => {
                    this.expenses = response.data;
                });
            },

            expenseModal(){
                this.editMode = false;
                this.form.category_id = "";
                this.form.amount = '';
                this.form.entry_date = "";
                this.errors = '';
                this.fetchCategory();
                $('#openModal').modal('show');
            },

            saveCategory(){
                axios.post('/api/expense/store?api_token='+window.token,this.form)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');  
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
                
            },
            fetchCategory(){
                axios.get('/api/category/index?api_token='+window.token)
                .then(response => {
                    this.categories = response.data;
                });
            },

            editExpenseModal(id){
                this.editMode = true;
                this.form.id = id;
                this.errors = '';
                this.fetchCategory();

                axios.get('/api/expense/show/'+id+'?api_token='+window.token)
                .then(response => {
                    this.form.category_id = response.data.category_id;
                    this.form.amount = response.data.amount;
                    this.form.entry_date = response.data.entry_date;
                });
                $('#openModal').modal('show');
            },

            updateExpenses(){
                axios.put('/api/expense/update/'+this.form.id+'?api_token='+window.token,this.form)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
            },

            deleteExpenses(){
                axios.get('/api/expense/delete/'+this.form.id+'?api_token='+window.token)
                .then(response => {
                    Fire.$emit('loadData');
                    $('#openModal').modal('hide');
                });
                
            }
            
        },
        mounted() {
            Fire.$on('loadData', ()=>{
                this.listOfExpenses();
            });
            this.listOfExpenses();
            console.log('Component mounted.')
        }
    }
</script>
