<template>
  <v-container>
        
        <v-window v-model= step >  
        <v-window-item :value="1">
         <div>
       <v-btn color="blue" dark title elevation="5" @click="(step=2)">Crear Profesor</v-btn>
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
            Apellido
          </th>
          <th class="text-left">
            Mostrar
          </th>
          <th class="text-left">
            Acciones
          </th>
          
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="profesor in profesores"
          :key="profesor.id"
        >
          <td>{{ profesor.id }}</td>
          <td>{{ profesor.nombre }}</td>
          <td>{{ profesor.apellido }}</td>
          <td>{{ profesor.mostrar }}</td>
          <v-btn color="green" dark title elevation="6" @click="(step=3)" >
            <v-icon center >mdi-pencil</v-icon>
          </v-btn>
          <v-btn color="red" dark title elevation="6"  @click="eliminarProfesor(profesor.id)" >
            <v-icon center >mdi-trash-can</v-icon>
          </v-btn>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
   </v-window-item >
    <v-window-item :value="2">
                    <div>
                        <v-btn color="blue" elevation="10" dark title @click="(step=1)">Volver</v-btn>
                        </div> 
                        <v-col cols="12" sm="6">
                            <v-card-text class="mt-12">
                                <h2 class="tex-center">Crear Nuevo Profesor</h2>
                                 <v-spacer></v-spacer>
                                  <v-row>
                                    <v-col cols="12" sm="12">
                                        <v-text-field  v-model="nuevoProfesor.nombre" elevation="10" label="Nombre" outlined dense color="blue"  class="mt-4"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12">
                                        <v-text-field v-model="nuevoProfesor.apellido" elevation="10" label="Apellido" outlined dense color="blue"  class="mt-4"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12">
                                        <v-text-field v-model="nuevoProfesor.mostrar" elevation="10" label="Mostrar" outlined dense color="blue"  class="mt-4"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-btn color="green" dark block title elevation="10" @click="agregarProfesor">Crear</v-btn>
                                
                            </v-card-text>
                        </v-col>
                    </v-window-item>
   
                    <v-window-item :value="3">
                    <div>
                        <v-btn color="blue" elevation="10" dark title @click="(step=1)">Volver</v-btn>
                        </div> 
                        <v-col cols="12" sm="6">
                            <v-card-text class="mt-12">
                                <h2 class="tex-center">Editar Profesor</h2>
                                 <v-spacer></v-spacer>
                                  <v-row>
                                    <v-col cols="12" sm="12">
                                        <v-text-field   v-model="profesor.nombre" elevation="10" label="Nombre" outlined dense color="blue"  class="mt-4"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12">
                                        <v-text-field  elevation="10" label="Apellido" outlined dense color="blue"  class="mt-4"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12">
                                        <v-text-field  elevation="10" label="Mostrar" outlined dense color="blue"  class="mt-4"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-btn color="green" dark block title elevation="10" @click="editarProfesor">Editar</v-btn>
                                
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
    data(){
        return {
            profesores:{
              id:'',
              nombre:'',
              apellido:'',
              mostrar:'',
            }, 
            nuevoProfesor:{
              nombre:'',
              apellido:'',
              mostrar:'',
            }, 
           step : 1,
        }
    },
    mounted: function(){
      var vue=this
      vue.listarProfesores()
    },
      
   methods:{
    agregarProfesor(){
      var vue=this
      console.log(this.nuevoProfesor)
      axios.post("apiv1/profesor", this.nuevoProfesor)
      .then(function (response){
        console.log(response)
        vue.listarProfesores()
        alert('Profesor Creado con exito')
        
      })
          
      },
     listarProfesores(){
        var vue=this
        axios.get("apiv1/profesor")
            .then (function (response){
                vue.profesores=response.data;   
            }) 
      },
      eliminarProfesor(id){
        var vue=this
        axios.delete("apiv1/profesor/" + id)
        .then(function(response){
          console.log(response);
           vue.listarProfesores()
          alert('Profesor eliminado con exito')
         
        })
      },
      editarProfesor(){

      }
   }
      
      
}

</script> 