<template>
    <v-container>
        <h1> HORARIOS DE MATERIAS </h1> <br>
        <v-window v-model=step>
            <v-window-item :value="1">
                <div>
                    <v-btn color="blue" dark title elevation="5" @click="(step = 2)">Crear Horario</v-btn>
                </div>
                <v-simple-table>

                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    ID
                                </th>
                                <th class="text-left">
                                    ID Materia
                                </th>
                                <th class="text-left">
                                    ID Reserva
                                </th>
                                <th class="text-left">
                                    Fecha y Hora Desde
                                </th>
                                <th class="text-left">
                                    Fecha y Hora Hasta
                                </th>

                                <th class="text-left">
                                    Acciones
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="HorarioMateria in HorariosMaterias" :key="HorarioMateria.id">
                                <td>{{ HorarioMateria.id }}</td>
                                <td>{{ HorarioMateria.id_materia }}</td>
                                <td>{{ HorarioMateria.id_reserva }}</td>
                                <td>{{ HorarioMateria.fh_desde }}</td>
                                <td>{{ HorarioMateria.fh_hasta }}</td>

                                <v-btn color="green" dark title elevation="6" @click="mostrarHorario(aula.id, step = 3)">
                                    <v-icon center>mdi-pencil</v-icon>
                                </v-btn>

                                <v-btn color="red" dark title elevation="6" @click="eliminarHorario(HorarioMateria.id)">
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
                        <h2 class="tex-center">Crear Nuevo Horario</h2>
                        <v-spacer></v-spacer>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-select v-model="nuevoHorarioMateria.id_materia" :items=materias label="Materia"
                                    item-value="id" required outlined dense color="blue" class="mt-4">
                                </v-select>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-select v-model="nuevoHorarioMateria.id_reserva" :items=reservas label="Reserva"
                                    item-value="id" required outlined dense color="blue" class="mt-4">
                                </v-select>
                            </v-col>
                            <div>

                                <v-menu ref="menu" v-model="menu" :close-on-content-click="false"
                                    transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="date" label="Fecha" prepend-icon="mdi-calendar" readonly
                                            v-bind="attrs" v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker locale="es" v-model="date" :active-picker.sync="activePicker"
                                        :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
                                        min="1950-01-01" @change="save"></v-date-picker>
                                </v-menu>
                            </div>
                            <v-col cols="12" sm="12">
                                <v-select v-model="horad" :items=hora label="Hora Desde" required outlined dense
                                    color="blue" class="mt-4">
                                </v-select>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-select v-model="horah" :items=hora label="Hora Hasta" required outlined dense
                                    color="blue" class="mt-4">
                                </v-select>
                            </v-col>
                        </v-row>
                        <v-spacer></v-spacer>
                        <v-btn color="green" dark block title elevation="10" @click="crearHorario(step = 1)">Crear
                        </v-btn>

                    </v-card-text>
                </v-col>
            </v-window-item>
        </v-window>
    </v-container>
</template>


<script>


import axios from "axios"

export default {
    name: 'AulasHorarioMateria',

    data() {
        return {
            activePicker: null,
            date: null,
            menu: false,
            hora: [
                '08:00',
                '08:30',
                '09:00',
                '09:30',
                '10:00',
                '10:30',
                '11:00',
                '11:30',
                '12:00',
                '12:30',
                '13:00',
                '13:30',
                '14:00',
                '14:30',
                '15:00',
                '15:30',
                '16:00',
                '16:30',
                '17:00',
                '17:30',
                '18:00',
                '18:30',
                '19:00',
                '19:30',
                '20:00',
                '20:30',
                '21:00',
                '21:30',
            ],
            materias: [],
            reservas:[],
            horad: '08:00:00',
            horah: '09:00:00',
            HorariosMaterias: [],
            nuevoHorarioMateria: {
                id_materia: '',
                id_reserva: '',
                fh_desde: '',
                fh_hasta: '',
                },

            step: 1,
        }
    },

    mounted: function () {
        var that = this
        that.listarHorariosMaterias()
        that.cargarMaterias()
        that.cargarReservas()

    },
    methods: {

        save(date) {
            var that = this
            that.$refs.menu.save(date)
            console.log(that.date)
            that.nuevoHorarioMateria.fh_desde = that.date
            that.nuevoHorarioMateria.fh_hasta = that.date

        },
        listarHorariosMaterias() {
            var that = this
            axios.get("apiv1/horariomateria")
                .then(function (response) {
                    that.HorariosMaterias = response.data;
                })
        },
        crearHorario() {
            var that = this
            that.nuevoHorarioMateria.fh_desde += " " + that.horad
            that.nuevoHorarioMateria.fh_hasta += " " + that.horah
            axios.post("apiv1/horariomateria", this.nuevoHorarioMateria)
                .then(function (response) {
                    console.log(response)
                    that.listarHorariosMaterias()
                    alert('Horarico creado con exito')

                })
        },
        eliminarHorario(id) {
            var that = this
            axios.delete("apiv1/horariomateria/" + id)
                .then(function (response) {
                    console.log(response);
                    that.listarHorariosMaterias()
                    alert('Horario eliminado con exito')

                })
        },
        cargarMaterias() {
            var that = this
            axios.get("apiv1/materia")
                .then(function (response) {
                    for (let i = 0; i < response.data.length; i++) {
                        let materias = []
                        materias.id = response.data[i].id;
                        materias.text = response.data[i].nombre;
                        that.materias.push(materias)

                    }
                })
        },
        cargarReservas() {
            var that = this
            axios.get("apiv1/reservaaula")
                .then(function (response) {
                    for (let i = 0; i < response.data.length; i++) {
                        let reservas = []
                        reservas.id = response.data[i].id;
                        reservas.text = response.data[i].id_aula;
                        that.reservas.push(reservas)

                    }
                })
        },
    }
}

</script>