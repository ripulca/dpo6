import axios from "axios";

const PATH_PREFIX = '/api/cv';

export const api = {
    getAll: getAll,
    getById: getById,
    add: add,
    edit: edit,
    updateStatus: updateStatus,
};

function getAll() {
    return get('/');
}

function getById(id) {
    return get('/' + id);
}

function add(resume) {
    return post('/add', resume);
}

function edit(id, resume) {
    return post('/' + id + '/edit', resume);
}

function updateStatus(id, newStatus) {
    return post('/' + id + '/status/update', {
        status: newStatus
    });
}

function get(url, config = {}) {
    return axios.get(PATH_PREFIX + url, config)
}

function post(url, data = {}, config = {}) {
    const json = JSON.stringify(data, (k, v) => {
       if (v === '') {
           return undefined;
       }
       return v;
    });

    return axios.post(PATH_PREFIX + url, json, config)
}