import * as mutations from './types/mutations';

export default {
    [mutations.SET_NOTIFICATION]: (state, notification) => {
        state.notifications = state.notifications.concat(notification);
    }
};
