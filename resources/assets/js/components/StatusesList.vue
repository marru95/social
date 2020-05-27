<template>
    <div>
        <div class="card border-0 mb-3 shadow" v-for="status in statuses">
            <div class="card-body d-flex flex-column">
                <div class=" d-flex align-items-center mb-3">
                <img class="rounded mr-3 shadow" width="40px" src="Imagen-2.jpg" alt="">
                    <div class="">
                        <h5 class="mb-1">Marruan Adib</h5>
                        <div class="small text-muted" >Hace una hora</div>
                    </div>
                </div>
                <p class="card-text text-secondary" v-text="status.body"></p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                statuses: []
            }
        },
        mounted() {
            axios.get('/statuses')
                .then(res => {
                    this.statuses = res.data.data
                })
                .catch(err => {
                    console.log(err.response.data);
                });

            EventBus.$on('status-created', status => {
                this.statuses.unshift(status);
            })
        }

    }
</script>

<style scoped>

</style>
