 <template>
    <v-container>
        <h1>LISTADO DE AULAS</h1> <br>
        <v-window v-model=step>
            <v-window-item :value="1">
                <div>
                    <v-btn color="blue" dark title elevation="5" @click="(step = 2)">Crear Aula</v-btn>
                </div>
                <v-simple-table>

                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    ID
                                </th>
                                <th class="text-left">
                                    Aula Nro
                                </th>
                                <th class="text-left">
                                    Ubicacion
                                </th>
                                <th class="text-left">
                                    Cantidad de Proyectores
                                </th>
                                <th class="text-left">
                                    Aforo
                                </th>
                                <th class="text-left">
                                    Es Climatisada?
                                </th>
                                <th class="text-left">
                                    Acciones
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="aula in aulas" :key="aula.id">
                                <td>{{ aula.id }}</td>
                                <td>{{ aula.descripcion }}</td>
                                <td>{{ aula.ubicacion }}</td>
                                <td>{{ aula.cant_proyector }}</td>
                                <td>{{ aula.aforo }}</td>
                                <td>{{ aula.es_climatizada }}</td>
                                <v-btn color="green" dark title elevation="6" @click="mostrarAula(aula.id, step = 3)">
                                    <v-icon center>mdi-pencil</v-icon>
                                </v-btn>

                                <v-btn color="red" dark title elevation="6" @click="eliminarAula(aula.id)">
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
                        <h2 class="tex-center">Crear Nueva Aula</h2>
                        <v-spacer></v-spacer>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="nuevaAula.descripcion" elevation="10" label="Aula Numero"
                                    outlined dense color="blue" class="mt-4"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="nuevaAula.ubicacion" elevation="10" label="Ubicacion" outlined
                                    dense color="blue" class="mt-4"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="nuevaAula.cant_proyector" elevation="10"
                                    label="Cantidad de proyectores" outlined dense color="blue" class="mt-4">
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="nuevaAula.aforo" elevation="10" label="Aforo" outlined dense
                                    color="blue" class="mt-4"></v-text-field>
                            </v-col>
                            <v-switch v-model="nuevaAula.es_climatizada" elevation="10" :label="`Switch 1: ${switch1.toString()}`"></v-switch>
                        </v-row>
                        <v-btn color="green" dark block title elevation="10" @click="agregarAula(step = 1)">Crear
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
                        <h2 class="tex-center">Editar Aula</h2>
                        <v-spacer></v-spacer>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="aula.descripcion" elevation="10" label="Descripcion" outlined
                                    dense color="blue" class="mt-4"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="aula.ubicacion" elevation="10" label="Ubicacion" outlined dense
                                    color="blue" class="mt-4"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="aula.cant_proyector" elevation="10"
                                    label="Cantidad de Proyectores" outlined dense color="blue" class="mt-4">
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="aula.aforo" elevation="10" label="Aforo" outlined dense
                                    color="blue" class="mt-4"></v-text-field>
                            </v-col>
                            <v-switch v-model="aula.es_climatizada" elevation="10" :label="`Switch 1: ${switch1.toString()}`"></v-switch>
                            
                        </v-row>
                        <v-btn color="green" dark block title elevation="10"
                            @click="editarAula(aula.id, aula, (step = 1))">
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
    name: 'AulasAulas',
    data() {
        return {
            aulas: [],
            nuevaAula: {
                descripcion: '',
                ubicacion: '',
                cant_proyector: '',
                aforo: '',
                es_climatizada: '',
            },
            aula: {
                id: '',
                descripcion: '',
                ubicacion: '',
                cant_proyector: '',
                aforo: '',
                es_climatizada: '',
            },
            step: 1,
            switch1: true,
        }
    },
    mounted: function () {
        var that = this
        that.listarAulas()
    },

    methods: {
        agregarAula() {
            var that = this
            console.log(this.nuevaAula)
            axios.post("apiv1/aula", this.nuevaAula)
                .then(function (response) {
                    console.log(response)
                    that.listarAulas()
                    alert('Aula Creada con exito')

                })

        },
        listarAulas() {
            var that = this
            axios.get("apiv1/aula")
                .then(function (response) {
                    that.aulas = response.data;
                })
        },
        eliminarAula(id) {
            var that = this
            axios.delete("apiv1/aula/" + id)
                .then(function (response) {
                    console.log(response);
                    that.listarAulas()
                    alert('Aula eliminada con exito')

                })
        },
        editarAula(id, aula) {
            var that = this
            console.log(aula)
            axios.put("apiv1/aula/" + id, aula)
                .then(function (response) {
                    console.log(response)
                    that.listarAulas()
                    alert('Aula editada con exito')
                })
        },
        mostrarAula(id) {
            var that = this
            axios.get("apiv1/aula/" + id)
                .then(function (response) {
                    that.aula = response.data;

                })
        },

    }


}

</script> 