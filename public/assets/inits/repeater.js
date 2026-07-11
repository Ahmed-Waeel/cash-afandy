/**
 * Initialize the repeater input.
 *
 * @param {string} selector
 * @param {object} options
 * @see RedotRepeater
 */
return (selector, options = {}) => {
    const defaultOptions = {
        sortable: true,
        scrollable: true,
        confirmable: true,
    };

    const selectorOptions = getOptionsFromSelector(selector, 'repeater-');
    options = _.merge(defaultOptions, selectorOptions, options);

    const repeater = new RedotRepeater(selector, options);

    // Set the instance on the input element.
    $(selector).data('repeater', repeater);
};
