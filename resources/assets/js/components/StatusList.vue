<template>
    <div @click="redirectIfGuest">

        <status-list-item
        v-for="status in statuses"
        :status="status"
        :key="status.id"
        ></status-list-item>
    </div>
</template>

<script>
    import StatusListItem from "./StatusListItem"
    export default {
        components: { StatusListItem },
        data(){
          return{
              statuses: []
          }
        },
        mounted() {
            axios.get('/statuses')
            .then(res=>{
                this.statuses=res.data.data
            })
            .catch(err=>{
                console.log(err.response.data);
            });
            EventBus.$on('status-created', status=>{
               this.statuses.unshift(status);
               console.log(status);
            });
        },
        methods: {
            like(status){
                axios.post(`/statuses/${status.id}/likes`)
                 .then(res => {
                    status.is_liked = true;
                    status.likes_count++;
                 })
            },
            unlike(status){
                axios.delete(`/statuses/${status.id}/likes`)
                    .then(res => {
                        status.is_liked = false;
                        status.likes_count--;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
