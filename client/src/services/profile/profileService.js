import requestService from '@/services/requestService';

export default {
    async updatePassword(password, oldPassword) {
        return await requestService.patch('/profiles/', {
            password: password,
            oldPassword: oldPassword
        });
    },

    async saveBranding(url) {
        return await requestService.patch('/profiles/', { logo: url });
    },

    async updateProfile(data) {
        return await requestService.put('/profiles/my', { data });
    }
};
