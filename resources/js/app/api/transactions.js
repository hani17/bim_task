import request from "./request";

export const getTransactionsForAdmin = (page = 1) => {
    return request.get(`/api/v1/admin/transactions?page=${page}`);
};

export const getTransactionsForCustomer = (page = 1) => {
    return request.get(`/api/v1/customer/transactions?page=${page}`);
};


