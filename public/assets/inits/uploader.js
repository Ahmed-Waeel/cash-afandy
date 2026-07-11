/**
 * Initialize the uploader input.
 *
 * @param {string} selector
 * @param {object} options
 * @see RedotUploader
 */
return (selector, options = {}) => {
    const defaultOptions = {
        sortable: true,
        multiple: true,
        accept: '*',
        autoUpload: true,
        maxSize: 10 * 1024 * 1024,
        confirmable: true,
        returnType: 'object',
    };

    const selectorOptions = getOptionsFromSelector(selector, 'uploader-');
    options = _.merge(defaultOptions, selectorOptions, options);

    const uploader = new RedotUploader(selector, options);

    // Set the instance on the input element.
    $(selector).data('uploader', uploader);
};
