import * as actions from './types/actions';
import * as mutations from './types/mutations';
import {v4 as uuidv4} from "uuid";

export default {
    [actions.SET_ERROR_NOTIFICATION]: async ({ commit }, text) => {
        commit(mutations.SET_NOTIFICATION, {
            id: uuidv4(),
            showing: true,
            text: text,
            type: 'error'
        });
    },

    [actions.REMOVE_ERROR_NOTIFICATION]: async ({ commit }, id) => {
        console.log('Delete with ' + id);
        commit(mutations.REMOVE_NOTIFICATION, id);
    }
};
