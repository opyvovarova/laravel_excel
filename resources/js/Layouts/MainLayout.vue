<template>
    <div class="w-96 mx-auto">
        <navigation></navigation>
      
        <slot />
    </div> 
</template>


<script>

import { Link } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';

    export default {
        name: "MainLayout",

        components: {
            Link,
            Navigation
        }
    }
</script>

<style lang="scss" scoped>

</style>