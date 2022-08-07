<template>
    <v-col cols="12" sm="12">
        <v-container>
            <v-window v-model=step>
                <v-window-item :value="1">
                    <h1>LISTADO DE MATERIAS</h1> <br>
                    <div>
                        <v-btn color="blue" dark title elevation="5" @click="(step = 2)">Crear Materia</v-btn>
                    </div>
                    <v-simple-table>

                        <template v-slot:default>
                            <thead>
                                <tr>
                                    <th class="text-left">
                                        ID
                                    </th>
                                    <th class="text-left">
                                        Nombre
                                    </th>
                                    <th class="text-left">
                                        Cantidad de Alumnos
                                    </th>
                                    <th class="text-left">
                                        Carrera
                                    </th>
                                    <th class="text-left">
                                        Profesor
                                    </th>
                                    <th class="text-left">
                                        Acciones
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="materia in materias" :key="materia.id">

                                    <td>{{ materia.id }}</td>
                                    <td>{{ materia.nombre }}</td>
                                    <td>{{ materia.cant_alumnos }}</td>
                                    <td>{{ materia.carrera.nombre }}</td>
                                    <td>{{ materia.profesor.nombre }} {{ materia.profesor.apellido }}</td>
                                    <v-btn color="green" dark title elevation="6"
                                        @click="mostrarMateria(materia.id, step = 3)">
                                        <v-icon center>mdi-pencil</v-icon>
                                    </v-btn>

                                    <v-btn color="red" dark title elevation="6" @click="eliminarMateria(materia.id)">
                                        <v-icon center>mdi-trash-can</v-icon>
                                    </v-btn>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-window-item>
                <v-window-item :value="2">
                    <div>
                        <v-btn color="blue" elevation="10" dark title @click="(step = 1)">Volver</v-btn>
                    </div>
                    <v-col cols="12" sm="6">
                        <v-card-text class="mt-12">
                            <h2 class="tex-center">Crear Nueva Materia</h2>
                            <v-spacer></v-spacer>
                            <v-row>
                                <v-col cols="12" sm="12">
                                    <v-text-field v-model="nuevaMateria.nombre" elevation="10" label="Nombre Materia"
                                        outlined dense color="blue" class="mt-4"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-text-field v-model="nuevaMateria.cant_alumnos" elevation="10"
                                        label="Cantidad de Alumnos" outlined dense color="blue" class="mt-4">
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-select v-model="nuevaMateria.id_carrera" :items=carreras item-value="id"
                                        label="Carrera" required outlined dense color="blue" class="mt-4">
                                    </v-select>
                                </v-col>
                                <v-spacer></v-spacer>
                                <v-col cols="12" sm="12">
                                    <v-select v-model="nuevaMateria.id_profesor" :items=profesores item-value="id"
                                        label="Profesor" required outlined dense color="blue" class="mt-4">
                                    </v-select>
                                </v-col>
                            </v-row>
                            <br>
                            <br>
                            <v-btn color="green" dark block title elevation="10" @click="crearMateria(step = 1)">Crear
                            </v-btn>

                        </v-card-text>
                    </v-col>
                </v-window-item>
                <v-window-item :value="3">
                    <div>
                        <v-btn color="blue" elevation="10" dark title @click="(step = 1)">Volver</v-btn>
                    </div>
                    <v-col cols="12" sm="6">
                        <v-card-text class="mt-12">
                            <h2 class="tex-center">Editar Materia</h2>
                            <v-spacer></v-spacer>
                            <v-row>
                                <v-col cols="12" sm="12">
                                    <v-text-field v-model="materiamodificada.nombre" elevation="10"
                                        label="Nombre Materia" outlined dense color="blue" class="mt-4"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-text-field v-model="materiamodificada.cant_alumnos" elevation="10"
                                        label="Cantidad de Alumnos" outlined dense color="blue" class="mt-4">
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-select v-model="carrera_select" :items=carreras item-value="id"
                                        @input="capturarIdCarrera()" required outlined dense color="blue" class="mt-4">
                                    </v-select>
                                </v-col>
                                <v-spacer></v-spacer>
                                <v-col cols="12" sm="12">
                                    <v-select v-model="profesor_select" :items=profesores item-value="id"
                                        @input="capturarIdProfesor()" required outlined dense color="blue" class="mt-4">
                                    </v-select>
                                </v-col>
                            </v-row>
                            <br>
                            <br>
                            <v-btn color="green" dark block title elevation="10"
                                @click="editarMateria(materiamodificada.id, materiamodificada, step = 1)">Editar
                            </v-btn>

                        </v-card-text>
                    </v-col>
                </v-window-item>
            </v-window>
        </v-container>
    </v-col>
</template>



<script>
import axios from 'axios'
export default {
    data() {
        return {

            carreras: [],

            profesores: [],

            materias: [],


            materiamodificada: {
                id: '',
                nombre: '',
                cant_alumnos: '',
                id_carrera: '',
                id_profesor: '',
            },
            profesor_select: '',
            carrera_select: '',
            nuevaMateria: {
                id: '',
                nombre: '',
                cant_alumnos: '',
                id_carrera: '',
                id_profesor: '',

                carrera: [],

                profesor: [],

            },
            step: 1,

        }
    },
    mounted: function () {
        var that = this
        that.listarMaterias()
        that.cargarCarreras()
        that.cargarProfesores()

    },

    methods: {

        listarMaterias() {
            var that = this
            axios.get("apiv1/materia")
                .then(function (response) {
                    that.materias = response.data;
                    console.log(response.data)
                });
        },

        crearMateria() {
            var that = this
            axios.post("apiv1/materia", this.nuevaMateria)
                .then(function (response) {
                    console.log(response)
                    that.listarMaterias()
                    alert('Materia creada con exito')

                })
        },

        cargarCarreras() {
            var that = this
            axios.get("apiv1/carrera")
                .then(function (response) {
                    for (let i = 0; i < response.data.length; i++) {
                        let carrera = []
                        carrera.id = response.data[i].id;
                        carrera.text = response.data[i].nombre;
                        that.carreras.push(carrera)

                    }


                })
        },
        cargarProfesores() {
            var that = this

            axios.get("apiv1/profesor")
                .then(function (response) {
                    for (let i = 0; i < response.data.length; i++) {
                        let profesor = []
                        profesor.id = response.data[i].id;
                        profesor.text = response.data[i].nombre + ' ' + response.data[i].apellido;
                        that.profesores.push(profesor)

                    }


                })
        },
        eliminarMateria(id) {
            var that = this
            axios.delete("apiv1/materia/" + id)
                .then(function (response) {
                    console.log(response);
                    that.listarMaterias()
                    alert('Materia eliminada con exito')

                })
        },
        mostrarMateria(id) {
            var that = this
            axios.get("apiv1/materia/" + id)
                .then(function (response) {

                    const {
                        id,
                        nombre,
                        cant_alumnos,
                        profesor,
                        carrera
                    } = response.data;
                    that.materiamodificada.id = id;
                    that.materiamodificada.nombre = nombre;
                    that.materiamodificada.cant_alumnos = cant_alumnos;
                    that.materiamodificada.id_carrera = carrera.id
                    that.materiamodificada.id_profesor = profesor.id
                    that.carrera_select = { text: response.data.carrera.nombre, id: response.data.carrera.id }
                    that.profesor_select = { text: response.data.profesor.nombre + " " + response.data.profesor.apellido, id: response.data.profesor.id }
                    console.log(that.materiamodificada)
                })
        },
        editarMateria(id, materia) {
            var that = this

            console.log(materia)
            axios.put("apiv1/materia/" + id, materia)
                .then(function () {
                    that.listarMaterias()
                    alert('Materia editada con exito')
                })
        },
        capturarIdProfesor() {

            this.materiamodificada.id_profesor = this.profesor_select
        },
        capturarIdCarrera() {

            this.materiamodificada.id_carrera = this.carrera_select
        },
    }
}
</script>




