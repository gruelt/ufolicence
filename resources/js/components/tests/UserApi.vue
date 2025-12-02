<script setup lang="ts">

import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/vue3';
interface Props {
    title: string;
    description?: string;
}

defineProps<Props>();
function getUser(){

    // router.visit('test', {
    //     only: ['title'],
    // })
    router.reload(
        { only: ['title']
    })

}

//getUser()

</script>

<template>

    <div>
        le titre :  {{title}} <br>
        la description : {{description}} <br>
        <Button @click="getUser"> Update</Button>
    </div>

</template>

<style scoped>

</style>
