<template>
    
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label for="password">Current Password</label>
                <input type="password" class="form-control" v-model="form.password">
                <span class="text-danger font-italic" v-if="errors.password" v-text="errors.password[0]"></span>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-4">
                <label for="contact" class="font-bold">New Password</label>
                <input type="password" class="form-control" v-model="form.newPassword">
                <span class="text-danger font-italic" v-if="errors.newPassword" v-text="errors.newPassword[0]"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="contact" class="font-bold">Confirm New Password</label>
                <input type="password" class="form-control" v-model="form.newPassword_confirmation">
            </div>
        </div>
        <div>
            <button class="btn btn-success mt-2" @click="btnPassword">Save</button>
        </div>
    </div>
</div>
            
</template>

<script>
    export default {
        data(){
            return {
                errors:{},
                form: new Form({
                    password:"",
                    newPassword:"",
                    newPassword_confirmation:"",
                }),
            }
        },
        methods:{
            btnPassword(){
                axios.post('/api/user/changePassword?api_token='+window.token,this.form)
                .then(response => {
                    this.errors = "";
                    Swal.fire('Change Password Successfully')  
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
