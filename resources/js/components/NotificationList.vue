<template>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle"
           dusk="notifications"
           href="#" id="DropdownNotifications"
           role="button"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false">
            <slot></slot>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownNotifications">
           <notification-list-item
               v-for="notification in notifications"
               :notification="notification"
               :key="notification.id"
           ></notification-list-item>

        </div>
    </li>
</template>

<script>
    import NotificationListItem from "./NotificationListItem";

    export default {
        components: { NotificationListItem },
        data() {
            return {
                notifications: []
            }
        },
        created() {
            axios.get('/notifications')
                .then(res => {
                    this.notifications = res.data;
                })
        }
    }
</script>

<style scoped>

</style>
