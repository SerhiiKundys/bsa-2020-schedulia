<template>
    <div>
        <h4 class="title-of-card pb-4">{{ lang.CHANGE_YOUR_PASSWORD }}</h4>
        <p class="info-text">
            {{ lang.PLEASE_ENTER_NEW_PASSWORD_FOR_USER_WITH_EMAIL }}
            <em>{{ $route.query.email }}</em>
        </p>
        <VForm @submit.prevent="onSubmit">
            <VCol cols="11" sm="11" md="8" class="pa-0 py-4">
                <label>{{ lang.PASSWORD }}*</label>
                <VTextField
                    :type="showPassword ? 'text' : 'password'"
                    :value="resetPasswordData.password"
                    :error-messages="passwordErrors"
                    @input="setPasswordOnInput"
                    @blur="setPassword"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPassword = !showPassword"
                    outlined
                    dense
                    class="rounded"
                />
            </VCol>
            <VCol cols="11" sm="11" md="8" class="pa-0 py-4">
                <label>{{ lang.CONFIRM_PASSWORD }}*</label>
                <VTextField
                    :type="showPassword ? 'text' : 'password'"
                    :value="resetPasswordData.confirmPassword"
                    :error-messages="confirmPasswordErrors"
                    @input="setConfirmedPasswordOnInput"
                    @blur="setConfirmedPassword"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPassword = !showPassword"
                    outlined
                    dense
                    class="rounded"
                />
            </VCol>
            <VCol cols="11" sm="11" md="8" class="pa-0">
                <VRow no-gutters align="center" justify="space-between">
                    <VBtn
                        height="44"
                        class="login-button  primary"
                        depressed
                        type="submit"
                        >{{ lang.SET_NEW_PASSWORD }}
                    </VBtn>
                    <RouterLink
                        :to="{ name: 'SignIn' }"
                        class="remembered-password "
                    >
                        {{ lang.REMEMBERED_PASSWORD }}
                    </RouterLink>
                </VRow>
            </VCol>
            <VSpacer class="pa-4" />
            <VCol cols="11" sm="11" md="8" class="pa-0">
                <ExplanationAlert
                    :visibility="resetPasswordData.explanationAlertVisibility"
                    :status="resetPasswordData.status"
                    :shot-description="resetPasswordData.shotDescription"
                    :explanation="resetPasswordData.explanation"
                />
            </VCol>
        </VForm>
    </div>
</template>

<script>
import * as actions from '@/store/modules/auth/types/actions';
import * as mutations from '@/store/modules/auth/types/mutations';
import { mapActions, mapState, mapMutations, mapGetters } from 'vuex';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { validationMixin } from 'vuelidate';
import { required, minLength, sameAs } from 'vuelidate/lib/validators';
import * as notificationActions from '@/store/modules/notification/types/actions';
import ExplanationAlert from '../common/Alerts/ExplanationAlert';

export default {
    name: 'ResetPassword',
    mixins: [validationMixin],
    validations: {
        resetPasswordData: {
            password: { required, minLength: minLength(8) },
            confirmPassword: { required, sameAsPassword: sameAs('password') }
        }
    },
    components: { ExplanationAlert },
    data: () => ({
        showPassword: false
    }),
    methods: {
        ...mapMutations('auth', {
            setExplanationAlert: mutations.SET_VISIBILITY_RESET,
            setPasswordState: mutations.SET_PASSWORD_RESET,
            setPasswordConfirm: mutations.SET_PASSWORD_CONFIRM_RESET,
            setEmail: mutations.SET_EMAIL_RESET,
            setToken: mutations.SET_TOKEN_RESET
        }),
        ...mapActions('auth', {
            resetPassword: actions.RESET_PASSWORD
        }),
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),
        setPassword(e) {
            this.setPasswordState(e.target.value);
            this.$v.resetPasswordData['password'].$touch();
        },
        setPasswordOnInput(value) {
            this.setPasswordState(value);
            this.$v.resetPasswordData['password'].$touch();
        },
        setConfirmedPassword(e) {
            this.setPasswordConfirm(e.target.value);
            this.$v.resetPasswordData['confirmPassword'].$touch();
        },
        setConfirmedPasswordOnInput(value) {
            this.setPasswordConfirm(value);
            this.$v.resetPasswordData['confirmPassword'].$touch();
        },
        async onSubmit() {
            try {
                this.setEmail(this.$route.query.email);
                this.setToken(this.$route.query.token);
                this.$v.$touch();
                if (this.$v.$invalid) {
                    throw new Error(this.lang.PLEASE_ENTER_CORRECT_DATA);
                }
                await this.resetPassword();
            } catch (error) {
                this.setErrorNotification(error?.message);
            }
        }
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapState('auth', ['resetPasswordData']),
        passwordErrors() {
            const errors = [];
            if (!this.$v.resetPasswordData['password'].$dirty) {
                return errors;
            }
            !this.$v.resetPasswordData['password'].required &&
                errors.push(this.lang.PASSWORD_IS_REQUIRED);
            !this.$v.resetPasswordData['password'].minLength &&
                errors.push(
                    this.lang.PASSWORD_MUST_BE_AT_LEAST_8_CHARACTERS_LONG
                );
            return errors;
        },
        confirmPasswordErrors() {
            const errors = [];
            if (!this.$v.resetPasswordData['confirmPassword'].$dirty) {
                return errors;
            }
            !this.$v.resetPasswordData['confirmPassword'].required &&
                errors.push(this.lang.PASSWORD_IS_REQUIRED);
            !this.$v.resetPasswordData['confirmPassword'].sameAsPassword &&
                errors.push(this.lang.PASSWORDS_DONT_MATCH);
            return errors;
        }
    }
};
</script>

<style scoped>
h4 {
    font-style: normal;
    font-weight: 900;
    font-size: 34px;
    line-height: 44px;
    letter-spacing: -0.44px;
}

.title-of-card {
    color: var(--v-primary-base);
}
.info-text {
    font-style: normal;
    font-weight: 500;
    font-size: 16px;
    line-height: 16px;
    color: var(--v-info-base);
}
.v-text-field.error--text::v-deep .v-input__slot {
    background-color: var(--v-validationError-base);
}
.v-text-field.error--text::v-deep .v-text-field__slot input {
    color: var(--v-error-darken1);
}
a {
    text-decoration: none;
}
label {
    font-style: normal;
    font-weight: 500;
    font-size: small;
    color: #2c2c2c;
    display: block;
}
.remembered-password {
    font-size: 0.875rem;
    color: var(--v-primary-base);
}
.login-button {
    text-transform: none;
}
</style>
