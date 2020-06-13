<template>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle"
           href="#"
           dusk="notifications"
           id="DropdownNotifications"
           :class="count ? 'text-primary font-weight-bold' : ''"
           role="button"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false">
            <slot></slot> {{ count }}
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownNotifications">
         <div class="dropdown-header text-center">Notificaciones</div>
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
                notifications: [],
                count: ''
            }
        },
        created() {
            axios.get('/notifications')
                .then(res => {
                    this.notifications = res.data;
                    this.unreadNotifications();
                });

            EventBus.$on('notification-read', () => {
                if (this.count === 1)
                {
                    return this.count = '';
                }
                this.count--;
            })
            EventBus.$on('notification-unread', () => {
                this.count++;

            })
        },
        methods: {
            unreadNotifications() {
                this.count = this.notifications.filter(notification => {
                    return notification.read_at === null;
                }).length || ''
            }
        }
    }


</script>

<style scoped>

</style>
