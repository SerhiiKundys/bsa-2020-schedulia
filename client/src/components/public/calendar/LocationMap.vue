<template>
    <div class="map-container">
        <MglMap
            :accessToken="accessToken"
            :mapStyle="'mapbox://styles/mapbox/streets-v11'"
            @load="onMapLoaded"
        >
            <MglMarker v-if="coords.length" :coordinates="coords" color="red" />
        </MglMap>
    </div>
</template>

<script>
import { MglMap, MglMarker } from 'vue-mapbox';
import '../../../../node_modules/mapbox-gl/dist/mapbox-gl.css';

const VUE_APP_MAPBOX_TOKEN = process.env.VUE_APP_MAPBOX_TOKEN;

export default {
    name: 'LocationMap',
    props: {
        coords: Array
    },
    components: {
        MglMap,
        MglMarker
    },
    data() {
        return {
            accessToken: VUE_APP_MAPBOX_TOKEN
        };
    },
    methods: {
        async onMapLoaded(event) {
            this.map = event.map;
            const asyncActions = event.component.actions;

            await asyncActions.flyTo({
                center: this.coords,
                zoom: 9,
                speed: 1
            });
        }
    }
};
</script>

<style scoped>
.map-container {
    width: 300px;
    height: 300px;
}
</style>
