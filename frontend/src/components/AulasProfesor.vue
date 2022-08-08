<template >
  <v-container >
 <h1>LISTADO DE PROFESORES</h1> <br>
    <v-window v-model=step >
      <v-window-item :value="1" color="blue">
        <div>
          <v-btn color="blue" dark title elevation="5" @click="(step = 2)">Crear Profesor</v-btn>
        </div>
        
        <v-simple-table >

          <template v-slot:default  >
            <thead>
              <tr>
                <th class="text-xs-left" >
                  ID
                </th>
                <th class="text-xs-left">
                  Nombre
                </th>
                <th class="text-xs-left">
                  Apellido
                </th>
                <th class="text-xs-left">
                  Mostrar
                </th>
                <th class="text-xs-left">
                  Acciones
                </th>

              </tr>
            </thead>
            <tbody >
              <tr v-for="profesor in profesores" :key="profesor.id">
                <td>{{ profesor.id }}</td>
                <td>{{ profesor.nombre }}</td>
                <td>{{ profesor.apellido }}</td>
                <td>{{ profesor.mostrar }}</td>
                <v-btn color="green" dark title elevation="6" @click="mostrarProfesor(profesor.id, step = 3)">
                  <v-icon center>mdi-pencil</v-icon>
                </v-btn>
                
                <v-btn color="red" dark title elevation="6" @click="eliminarProfesor(profesor.id)">
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
            <h2 class="tex-center">Crear Nuevo Profesor</h2>
            <v-spacer></v-spacer>
            <v-row>
              <v-col cols="12" sm="12">
                <v-text-field v-model="nuevoProfesor.nombre" elevation="10" label="Nombre" outlined dense color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="nuevoProfesor.apellido" elevation="10" label="Apellido" outlined dense
                  color="blue" class="mt-4"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="nuevoProfesor.mostrar" elevation="10" label="Mostrar" outlined dense color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
            </v-row>
            <v-btn color="green" dark block title elevation="10" @click="agregarProfesor(step=1)">Crear</v-btn>

          </v-card-text>
        </v-col>
      </v-window-item>
      <v-window-item :value="3">
        <div>
          <v-btn color="blue" elevation="10" dark title @click="(step = 1)">Volver</v-btn>
        </div>
        <v-col cols="12" sm="6">
          <v-card-text class="mt-12">
            <h2 class="tex-center">Editar Profesor</h2>
            <v-spacer></v-spacer>
            <v-row>
              <v-col cols="12" sm="12">
                <v-text-field v-model="profesor.nombre" elevation="10" label="Nombre" outlined dense color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="profesor.apellido" elevation="10" label="Apellido" outlined dense color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="profesor.mostrar" elevation="10" label="Mostrar" outlined dense color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
            </v-row>
            <v-btn color="green" dark block title elevation="10" @click="editarProfesor(profesor.id,profesor,(step=1))">Editar</v-btn>

          </v-card-text>
        </v-col>
      </v-window-item>

    </v-window>
  </v-container>
  
</template>

<script>


import axios from 'axios'

export default {
  name: 'AulasProfesor',
  data() {
    return {
      search: '',
      profesores:[],
      nuevoProfesor: {
        nombre: '',
        apellido: '',
        mostrar: '',
      },
      profesor: {
        id: '',
        nombre: '',
        apellido: '',
        mostrar: '',
      },
      step: 1,
    }
  },
  mounted: function () {
    var that = this
    that.listarProfesores()
  },

  methods: {
    agregarProfesor() {
      var that = this
      console.log(this.nuevoProfesor)
      axios.post("apiv1/profesor", this.nuevoProfesor)
        .then(function (response) {
          console.log(response)
          that.listarProfesores()
          alert('Profesor Creado con exito')

        })

    },
    listarProfesores() {
      var that = this
      axios.get("apiv1/profesor")
        .then(function (response) {
          that.profesores = response.data;
        })
    },
    eliminarProfesor(id) {
      var that = this
      axios.delete("apiv1/profesor/" + id)
        .then(function (response) {
          console.log(response);
          that.listarProfesores()
          alert('Profesor eliminado con exito')

        })
    },
    editarProfesor(id,profesor) {
      var that = this
      console.log(profesor)
      axios.put("apiv1/profesor/" + id, profesor)
        .then(function (response) {
          console.log(response)
        that.listarProfesores()
        alert('Profesor editado con exito')  
        })
    },
    mostrarProfesor(id) {
      var that = this
      axios.get("apiv1/profesor/" + id)
        .then(function (response) {
          that.profesor = response.data;
         
        })
    },

  }


}

</script> 