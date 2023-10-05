document.addEventListener('DOMContentLoaded', () => {
    const basketActions = {
        get redirectUrl() {
            return '/include/basket.php'; // Поменять при необходимости
        },

        getUrl(id, count, b_url) {
            const url = new URL(window.location.origin);
            url.pathname = '/cms/admin/basket.php';
            url.searchParams.set(`pl_plugin_order[${String(id)}]`, String(Number(count)));
            url.searchParams.set('b_url', String(b_url));

            return url;
        },

        getEvent(name, detail) {
            return new CustomEvent(`${name}_basket`, detail);
        },

        async request(id, count, b_url = basketActions.redirectUrl) {
            if (!id) {
                throw new Error('require first argument');
            }

            document.dispatchEvent(basketActions.getEvent('before_update', {id, count, b_url}));
            const response = await fetch(basketActions.getUrl(id, count, b_url));
            document.dispatchEvent(basketActions.getEvent('after_update', {id, count, b_url, response}));

            return response;
        },

        async plus(id, count = 1, b_url = basketActions.redirectUrl) {
            count = Number(count);

            if (count < 1) {
                throw new Error('count error');
            }

            document.dispatchEvent(basketActions.getEvent('before_plus', {id, count, b_url}));
            const response = await fetch(basketActions.getUrl(id, count, b_url));
            document.dispatchEvent(basketActions.getEvent('after_menus', {id, count, b_url, response}));

            return response;
        },

        async minus(id, count = 1, b_url = basketActions.redirectUrl) {
            count = -Number(count);

            if (count < 1) {
                throw new Error('count error');
            }

            document.dispatchEvent(basketActions.getEvent('before_minus', {id, count, b_url}));
            const response = await fetch(basketActions.getUrl(id, count, b_url));
            document.dispatchEvent(basketActions.getEvent('after_minus', {id, count, b_url, response}));
        },

        async remove(id, b_url = basketActions.redirectUrl) {
            const count = 0;

            document.dispatchEvent(basketActions.getEvent('before_remove', {id, count, b_url}));
            const response = await fetch(basketActions.getUrl(id, count, b_url));
            document.dispatchEvent(basketActions.getEvent('after_remove', {id, count, b_url, response}));

            return response;
        },

        async clear(b_url = basketActions.redirectUrl) {
            const id = 'del_orders';
            const count = 0;

            document.dispatchEvent(basketActions.getEvent('before_clear', {id, count, b_url}));
            const response = await fetch(basketActions.getUrl('del_orders', count, b_url));
            document.dispatchEvent(basketActions.getEvent('after_clear', {id, count, b_url, response}));

            return response;
        }
    };

    document.addEventListener('clear_basket', (e) => basketActions.clear(e.detail?.b_url));
});
