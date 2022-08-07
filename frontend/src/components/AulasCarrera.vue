<template>
  <v-container>
    <h1>LISTADO DE CARRERAS</h1> <br>
    <v-window v-model=step>
      <v-window-item :value="1">
        <div>
          <v-btn color="blue" dark title elevation="5" @click="(step = 2)">Crear Carrera</v-btn>
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
                  Acciones
                </th>

              </tr>
            </thead>
            <tbody>
              <tr v-for="carrera in carreras" :key="carrera.id">
                <td>{{ carrera.id }}</td>
                <td>{{ carrera.nombre }}</td>
                
                <v-btn color="green" dark title elevation="6" @click="mostrarCarrera(carrera.id, step = 3)">
                  <v-icon center>mdi-pencil</v-icon>
                </v-btn>
                <v-btn color="red" dark title elevation="6" @click="eliminarCarrera(carrera.id)">
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
            <h2 class="tex-center">Agregar Nueva Carrera</h2>
            <v-spacer></v-spacer>
            <v-row>
              <v-col cols="12" sm="12">
                <v-text-field v-model="nuevaCarrera.nombre" elevation="10" label="Nombre" outlined dense color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
            </v-row>
            <v-btn color="green" dark block title elevation="10" @click="agregarCarrera(step = 1)">Crear</v-btn>

          </v-card-text>
        </v-col>
      </v-window-item>
      <v-window-item :value="3">
        <div>
          <v-btn color="blue" elevation="10" dark title @click="(step = 1)">Volver</v-btn>
        </div>
        <v-col cols="12" sm="6">
          <v-card-text class="mt-12">
            <h2 class="tex-center">Editar Carrera</h2>
            <v-spacer></v-spacer>
            <v-row>
              <v-col cols="12" sm="12">
                <v-text-field v-model="carrera.nombre" elevation="10" label="Nombre" outlined dense color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
             </v-row>
            <v-btn color="green" dark block title elevation="10" @click="editarCarrera(carrera.id, carrera, (step = 1))">
              Editar</v-btn>

          </v-card-text>
        </v-col>
      </v-window-item>

    </v-window>
  </v-container>
</template>

<script>


import axios from 'axios'

export default {
  name: 'AulasCarrera',
  data() {
    return {
      carreras: {
        id: '',
        nombre: '',

      },
      nuevaCarrera: {
        nombre: '',
      },
      carrera: {
        id: '',
        nombre: '',

      },
      step: 1,
    }
  },
  mounted: function () {
    var that = this
    that.listarCarreras()
  },

  methods: {
    agregarCarrera() {
      var that = this
      console.log(this.nuevaCarrera)
      axios.post("apiv1/carrera", this.nuevaCarrera)
        .then(function (response) {
          console.log(response)
          that.listarCarreras()
          alert('Carrera Creada con exito')

        })

    },
    listarCarreras() {
      var that = this
      axios.get("apiv1/carrera")
        .then(function (response) {
          that.carreras = response.data;
        })
    },
    eliminarCarrera(id) {
      var that = this
      axios.delete("apiv1/carrera/" + id)
        .then(function (response) {
          console.log(response);
          that.listarCarreras()
          alert('Carrera eliminada con exito')

        })
    },
    editarCarrera(id, carrera) {
      var that = this
      console.log(carrera)
      axios.put("apiv1/carrera/" + id, carrera)
        .then(function (response) {
          console.log(response)
          that.listarCarreras()
          alert('Carrera editada con exito')
        })
    },
    mostrarCarrera(id) {
      var that = this
      axios.get("apiv1/carrera/" + id)
        .then(function (response) {
          that.carrera = response.data;

        })
    },

  }


}

</script> 