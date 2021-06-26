<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping">Items por pagina</span>
                    <select class="form-select" v-model="per_page" aria-label="Default select example">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
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
                            <tr v-for="e in laravelData.data" :key="e.id">
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
        <div class="row">
            <div class="col-12">
                <pagination :data="laravelData" @pagination-change-page="getEmployees" :limit="1" align="center" :show-disabled="true" >
                    <span slot="prev-nav">&lt; Anterior</span>
                    <span slot="next-nav">Siguiente &gt;</span>
                </pagination>
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
                per_page: 5,
                laravelData: {}
            }
        },
        mounted() {
            this.getEmployees();
        },
        methods: {
            async getEmployees(page = 1){
                try {
                    this.laravelData = (await axios.get('/employees?page=' + page + '&per_page=' + this.per_page)).data;
                } catch (error) {
                    console.error(error);
                }
            }
        },
        watch:{
            per_page(){
                this.getEmployees();
            }
        }
    }
</script>
