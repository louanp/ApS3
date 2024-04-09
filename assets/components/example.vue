<template>
    <h1>{{ greetingMessage }}</h1>
</template>
    
<script>
    export default {
        name: 'example',
        props: {
            greetingMessage: {
                type: String,
                default: 'Salut Vue.js depuis Symfony 6!'
            }
        }
    };
</script>
    
<style>
    h1 {
        color: blue;
    }
</style>