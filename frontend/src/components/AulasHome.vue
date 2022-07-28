<template>
    <div>
        <h1>PAGINA PRINCIPAL "HOME"</h1>
        
        
    </div>
</template>


<script>

export default {
    name: 'AulasHome',
    computed: {
        id(){
            return this.$route.params.id
        }
    }
}

</script>