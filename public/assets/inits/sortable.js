/**
 * Initialize the sortable list.
 *
 * @param {string} selector
 * @param {object} options
 * @see https://sortablejs.github.io/Sortable/
 */
return (selector, options = {}) => {
    const defaultOptions = {
        animation: 150,
    };

    const selectorOptions = getOptionsFromSelector(selector, 'sortable-');
    options = _.merge(defaultOptions, selectorOptions, options);

    const sortable = new Sortable($(selector).get(0), options);

    // Set the instance on the input element.
    $(selector).data('sortable', sortable);

    return sortable;
};
