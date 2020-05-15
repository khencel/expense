
<template>
    <div class="card">
        <div class="card-body">
            <h1>My Expences</h1>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Expences Categories</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="Object.keys(expenses).length == 0">
                                <td class="text-center" colspan="2">No Record...</td>
                            </tr>
                            <tr v-for="expense in expenses" :key="expense.id">
                                <td>{{expense.category.name}}</td>
                                <td>${{expense.amount}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <apexchart class="img-fluid" type="pie" :options="options" :series="series"></apexchart>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
   
    import VueApexCharts from 'vue-apexcharts'
    Vue.component('apexchart', VueApexCharts)

    export default {
        
        data () {
            return {
                options: {
                    labels: [
                    ]
                    
                },
                series: [],
                expenses:{}
            }
        },
        methods:{
            fetchExpense(){
                axios.get('/api/expense/index?api_token='+window.token)
                .then(response => {
                    this.expenses = response.data;
                    response.data.forEach(element => {
                        this.series.push(element.amount);
                        this.options.labels.push(element.category.name);                        
                    });
                    
                });
            },
        },
        mounted() {
            this.fetchExpense();
            console.log('Component mounted.')
        }
    }
</script>
