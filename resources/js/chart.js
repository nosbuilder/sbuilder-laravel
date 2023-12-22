import {Chart, registerables} from 'chart.js';

Chart.register(...registerables);

const pluck = (arr, key) => arr.map(i => i[key]);
const ctx = document.getElementById('testChart');

const data = JSON.parse(ctx.dataset.json);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: pluck(data, 'label'),
        datasets: [{
            label: 'Кол-во запросов в день',
            data: pluck(data, 'count'),
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
