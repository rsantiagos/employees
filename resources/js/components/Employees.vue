<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                    Nuevo empleado
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive-md">
                    <table class="table table-hover">
                       <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">DNI</th>
                            <th scope="col">email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="e in employees" :key="e.id">
                                <th scope="row">{{ e.id }}</th>
                                <td> <img :src="e.picture" class="img-fluid rounded-circle" height="35" width="35" :alt="e.name"> {{ e.name + ' ' + e.last_name }} </td>
                                <td> {{ e.dni }} </td>
                                <td> {{ e.user.email }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <NewEmployee />
    </div>
</template>

<script>
import NewEmployee from './NewEmployee.vue';
    export default {
        components: { NewEmployee },
        data() {
            return {
                employees: null
            }
        },
        mounted() {
            this.getEmployees();
        },
        methods: {
            async getEmployees(){
                try {
                    this.employees = (await axios.get('/employees')).data;
                } catch (error) {
                    console.error(error);
                }
            }
        },
    }
</script>
