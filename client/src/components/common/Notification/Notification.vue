<template>
    <VSnackbar
        :value="notification.showing"
        :color="notification.typeSnackbar"
        :timeout="timeout"
        :top="top"
        :style="`top: ${index * 60 + 15}px`"
    >
        <VRow>
            <VCol cols="11" md="11">
                <div v-if="notification.text.validatorError">
                    <div
                        v-for="(validatorError, index) in notification.text
                            .validatorError"
                        :key="index"
                    >
                        {{ validatorError }}
                    </div>
                </div>
                <div v-else>
                    {{ notification.text }}
                </div>
            </VCol>
            <VCol class="text-right" align-self="center" cols="1" md="1">
                <span class="close" @click="closeSnackbar">
                    <VIcon size="14">
                        mdi-close
                    </VIcon>
                </span>
            </VCol>
        </VRow>
    </VSnackbar>
</template>

<script>
import * as notificationActions from '@/store/modules/notification/types/actions';
import { mapActions } from 'vuex';

export default {
    name: 'Notification',

    props: {
        notification: {
            type: Object,
            required: true
        },
        index: {
            type: Number,
            required: true
        }
    },

    mounted() {
        this.timoutID = setTimeout(() => this.closeSnackbar(), 4000);
    },

    data() {
        return {
            top: true,
            timeout: -1,
            timoutID: null
        };
    },

    methods: {
        ...mapActions('notification', {
            removeErrorNotification:
                notificationActions.REMOVE_ERROR_NOTIFICATION
        }),

        closeSnackbar() {
            clearTimeout(this.timoutID);
            this.removeErrorNotification(this.notification.id);
        }
    }
};
</script>

<style scoped>
.close::v-deep {
    font-size: 16px;
    cursor: pointer;
}

.col-12::v-deep {
    padding: 0 5px;
}
</style>
