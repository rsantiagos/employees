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
                {{employees}}
            </div>
        </div>
        <new-employee />
    </div>
</template>

<script>
    export default {
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
