return (selector, options = {}) => {
    const $input = $(selector);

    // Ensure the input has an ID for Coloris selector
    if (!$input.hasAttr('coloris-id')) {
        $input.attr('coloris-id', _.uniqueId('coloris-'));
    }

    const defaultOptions = {
        rtl: $('html').attr('dir') === 'rtl',
        themeMode: localStorage.getItem(window.themerKey),
        theme: 'polaroid',
        formatToggle: true,
    };

    // Get the options from the selector
    const selectorOptions = getOptionsFromSelector(selector, 'coloris-');
    options = _.merge(defaultOptions, selectorOptions, options);

    // Initialize the color picker
    const picker = new Coloris({
        el: `[coloris-id="${$input.attr('coloris-id')}"`,
        ...options,
    });

    // Set the instance on the input element.
    $input.data('coloris', picker);
};
