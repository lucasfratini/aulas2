<template>
  <v-container>
    <v-app-bar
        app
        elevation="10"
        color="blue"
    >
     
      <v-app-bar-title >Administrador de Aulas </v-app-bar-title>
      <v-spacer></v-spacer>
      
      <v-btn small @click="logout">
        <v-icon>mdi-exit-to-app</v-icon>
      </v-btn>
    </v-app-bar>

  </v-container>
  
</template>

<script>
  export default {
    name: 'MainBar',

    data: () => ({
      items: [
        { title: 'MainMenu', to: '/MainMenu' },
        

        ],
    }),
    methods: {
      logout(){
        console.log('Logout...')
      }
    }
  }
</script>