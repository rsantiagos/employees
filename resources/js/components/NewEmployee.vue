<template>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-name">Nombre</span>
                            </div>
                            <input type="text" v-model="form.name" class="form-control" aria-label="name" aria-describedby="inputGroup-sizing-name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-last_name">Apellidos</span>
                            </div>
                            <input type="text" v-model="form.last_name" @blur="checkEmail()" class="form-control" aria-label="last_name" aria-describedby="inputGroup-sizing-last_name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-dni">DNI</span>
                            </div>
                            <input type="text" v-model="form.dni" class="form-control" aria-label="dni" aria-describedby="inputGroup-sizing-dni">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-birthdate">Fecha de nacimiento</span>
                            </div>
                            <input type="date" v-model="form.birthdate" class="form-control" aria-label="birthdate" aria-describedby="inputGroup-sizing-birthdate">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-address">Dirección</span>
                            </div>
                            <input type="text" v-model="form.address" class="form-control" aria-label="address" aria-describedby="inputGroup-sizing-address">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-photo">Foto</span>
                            </div>
                            <input type="file" class="form-control" aria-label="photo" aria-describedby="inputGroup-sizing-photo">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-email">Email</span>
                            </div>
                            <input type="text" v-model="form.email" class="form-control text-lowercase" aria-label="email" aria-describedby="inputGroup-sizing-email" disabled >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-password">Contraseña</span>
                            </div>
                            <input type="password" v-model="form.password" class="form-control" aria-label="password" aria-describedby="inputGroup-sizing-password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Puesto Laboral</label>
                            </div>
                            <select v-model="form.jobPosition_id" class="custom-select" id="inputGroupSelect01">
                                <option v-for="jb in jobPositions" :key="jb.id" :value="jb.id">
                                    {{ jb.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-entity_name">Nombre entidad</span>
                            </div>
                            <input type="text" v-model="form.entity_name" class="form-control" aria-label="entity_name" aria-describedby="inputGroup-sizing-entity_name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-entity_identifier">Identificador entidad</span>
                            </div>
                            <input type="text" v-model="form.entity_identifier" class="form-control" aria-label="entity_identifier" aria-describedby="inputGroup-sizing-entity_identifier">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> -->
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form:{
                name: null,
                last_name: null,
                dni: null,
                birthdate: null,
                address: null,
                picture: null,
                email: null,
                password: null,
                jobPosition_id: null,
                entity_name: null,
                entity_identifier: null
            },
            jobPositions:null
        }
    },
    mounted() {
        this.getJobPositions();
    },
    methods: {
        async checkEmail(){
            try {
                let params = {
                    name: this.form.name,
                    last_name: this.form.last_name
                }
                this.form.email = (await axios.post('/checkEmail', params)).data.email;
            } catch (error) {
                console.error(error);
            }
        },
        async getJobPositions(){
            try {
                this.jobPositions = (await axios.get('/job_positions')).data;
            } catch (error) {
                console.error(error);
            }
        }
    },

}
</script>

<style>

</style>
