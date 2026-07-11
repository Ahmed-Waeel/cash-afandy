/**
 * Initialize the icon picker input.
 *
 * @param {string} selector
 * @param {object} options
 * @see RedotIconPicker
 */
return (selector, options = {}) => {
    const defaultOptions = {
        endpoint: 'https://api.fontawesome.com',
        version: '6.4.2',
        maxResults: 100,
        searchDebounce: 100,
    };

    const selectorOptions = getOptionsFromSelector(selector, 'iconpicker-');
    options = _.merge(defaultOptions, selectorOptions, options);

    const iconPicker = new RedotIconPicker(selector, options);

    // Set the instance on the input element.
    $(selector).data('iconPicker', iconPicker);
};
