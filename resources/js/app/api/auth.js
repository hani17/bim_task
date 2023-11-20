import cookie from "cookiejs";
import request from "./request";

export const loginAsAdmin = (data) => {
    return request.post('/api/v1/admin/login', data);
};

export const loginAsCustomer = (data) => {
    return request.post('/api/v1/customer/login', data);
};

export const getUser = () => {
    return request.get('/api/v1/user');
};

export const getCsrf = () => {
    return request.get('/sanctum/csrf-cookie');
};

export const logout = () => {
    return request.get('/api/v1/logout');
};
