/**
 * Initialize an ApexCharts chart.
 *
 * @param {string} selector
 * @param {object} options
 * @returns {object|null}
 * @see https://apexcharts.com/docs/options/
 */
return (selector, options = {}) => {
    const $chart = $(selector);

    if (!window.ApexCharts) {
        console.error('ApexCharts is not loaded.');
        return null;
    }

    const defaultOptions = {
        chart: {
            type: 'line',
            height: 350,
            toolbar: {
                show: false,
            },
        },
        series: [],
    };

    const selectorOptions = getOptionsFromSelector(selector, 'chart-');

    for (const key of ['height', 'type', 'width']) {
        if (!selectorOptions.hasOwnProperty(key)) continue;

        _.set(selectorOptions, `chart.${key}`, selectorOptions[key]);
        delete selectorOptions[key];
    }

    options = _.merge(defaultOptions, selectorOptions, options);

    const chart = new ApexCharts($chart.get(0), options);

    chart.render();
    $chart.data('apexcharts', chart);

    return chart;
};
