<template>
    <GeneralLayout>
        <template v-slot:title>
            {{ lang.INTEGRATIONS }}
        </template>
        <VRow>
            <ConnectedCalendars />
        </VRow>
        <VRow>
            <ZoomIntegration />
        </VRow>
        <VRow>
            <WhaleIntegration />
        </VRow>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import ConnectedCalendars from '@/components/calendar-connections/ConnectedCalendars.vue';
import ZoomIntegration from '@/components/integrations/ZoomIntegration';
import WhaleIntegration from '@/components/integrations/WhaleIntegration';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'CalendarConnections',
    components: {
        GeneralLayout,
        ConnectedCalendars,
        ZoomIntegration,
        WhaleIntegration
    },
    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>
