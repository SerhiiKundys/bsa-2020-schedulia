<template>
    <div class="tabs">
        <div class="tabs__list">
            <VContainer class="tabs__container">
                <VToolbar color="white" dense flat>
                    <VRow align="end">
                        <VCol class="text-left">
                            <VTabs v-model="tab">
                                <VTab v-for="item in tabs" :key="item.tab">
                                    {{ item.title }}
                                </VTab>
                            </VTabs>
                        </VCol>
                        <VCol class="text-right" align-self="center">
                            <slot name="right-side"></slot>
                        </VCol>
                    </VRow>
                </VToolbar>
            </VContainer>
        </div>
        <BorderBottom />
        <VTabsItems v-model="tab">
            <VTabItem v-for="item in tabs" :key="item.tab">
                <Component v-bind:is="item.component"></Component>
            </VTabItem>
        </VTabsItems>
    </div>
</template>

<script>
import BorderBottom from '../common/GeneralLayout/BorderBottom';

export default {
    name: 'Tabs',
    components: {
        BorderBottom
    },
    props: {
        tabs: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        tab: null
    })
};
</script>

<style lang="scss" scoped>
.tabs {
    &__list {
        width: 100%;
        background: var(--v-background-lighten1);
    }

    &__container {
        padding: 0;
    }
}
.v-tab {
    text-transform: none;
}

.theme--light.v-tabs-items::v-deep,
.v-tabs-items::v-deep {
    background: none;
}
</style>
