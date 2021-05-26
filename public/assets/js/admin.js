const delay = ms => new Promise(res => setTimeout(res, ms));
const inputsDisabled = state => document.querySelectorAll('button, input, textarea').forEach(el => { el.disabled = state; });
const reload = () => window.location.reload();
const redirect = to => window.location.assign(to);

const formDataToJSON = data => {
    const object = {};
    [...data].map((item) => object[item[0]] = item[1]);

    return object;
}

const api = axios.create({
    baseURL: '/',
    headers: {
        'Content-Type': 'application/json'
    },
    validateStatus: () => {
        return true;
    },
});

const apiUse = (method, endpoint, data) => {
    inputsDisabled(true);

    return api[method](endpoint, data).then(async response => {
        if (response.data.success) {
            inputsDisabled(false);
        }

        const data = response.data.data;

        if (!data) {
            return;
        }

        if (response.data.message) {
            // TODO: bootstrap toast
            alert(response.data.message)
        }

        if (data.inputsDisabled !== null) {
            inputsDisabled(data.inputsDisabled);
        }

        if (data.redirect) {
            await delay(750);
            redirect(data.redirect);
        }

        if (data.reload) {
            await delay(750);
            reload();
        }

        return response.data;
    });
}

const updateRoom = id => {
    const form = document.querySelector(`#form-${id}`);
    const modal = document.querySelector(`#form-${id}`);
    const data = formDataToJSON(new FormData(form));

    // TODO: maybe activate spinner

    apiUse(
        'put',
        `/room/${id}`,
        data
    );

    // TODO: close modal
    // TODO: remove div from html
}

const deleteRoom = id => {
    if (confirm('Are you sure?')) {
        apiUse('delete', `/room/${id}`);
    }
}
