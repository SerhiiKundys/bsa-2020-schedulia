<template>
    <VSnackbar v-model="alertVisible" :color="color">
        {{ message }}
        <RouterLink :to="{ name: 'SignIn' }" v-if="isSuccessLogin">
            {{ lang.LOG_IN }}
        </RouterLink>
        <template v-slot:action="{ attrs }">
            <VBtn color="white" text v-bind="attrs" @click="closeAlert">
                {{ lang.CLOSE }}
            </VBtn>
        </template>
    </VSnackbar>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';
export default {
    name: 'Alert',
    props: {
        type: {
            type: String
        },
        message: {
            required: true
        },
        visibility: {
            required: true
        }
    },
    data: () => ({
        alertVisible: false
    }),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        color() {
            if (this.type.includes('success')) {
                return 'green';
            } else if (this.type === 'error') {
                return 'red';
            }
            return '';
        },
        isSuccessLogin() {
            return this.type === 'success.login';
        }
    },
    methods: {
        closeAlert() {
            this.alertVisible = false;
            this.$emit('user-deleted');
        }
    },
    watch: {
        visibility(value) {
            this.alertVisible = false;
            this.alertVisible = value;
        }
    }
};
</script>

<style scoped>
.v-snack__content a {
    color: #fff;
    font-weight: bold;
}
</style>
