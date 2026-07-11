/**
 * Initialize the tempus dominus date picker.
 *
 * @param {string} selector
 * @param {object} options
 * @returns {object}
 * @see https://getdatepicker.com/
 */
return (selector, options = {}) => {
    const $picker = $(selector);

    // Determine if the picker inside a rtl direction
    const isRtl = getComputedStyle($picker.get(0)).direction === 'rtl';

    const defaultOptions = {
        display: {
            theme: $('html').attr('data-bs-theme'),

            components: {
                calendar: true,
                clock: false,
            },

            icons: {
                previous: isRtl ? 'fa-solid fa-chevron-right' : 'fa-solid fa-chevron-left',
                next: isRtl ? 'fa-solid fa-chevron-left' : 'fa-solid fa-chevron-right',
            },
        },

        localization: {
            format: 'yyyy-MM-dd',
            hourCycle: 'h12',
        },
    };

    // Get the options from the selector
    const selectorOptions = getOptionsFromSelector(selector, 'date-');
    options = _.merge(defaultOptions, selectorOptions, options);

    // If the picker has the datetime attribute, add the time components
    if ($picker.hasAttr('datetime') || options.type === 'datetime') {
        options.display.components.clock = true;
        options.display.components.calendar = true;
        options.localization.format = 'yyyy-MM-dd hh:mm T';
    }

    // If the picker has only-time attribute, remove the date components
    if ($picker.hasAttr('only-time') || options.type === 'time') {
        options.display.components.calendar = false;
        options.display.components.clock = true;
        options.localization.format = 'hh:mm T';
    }

    // Remove the type option because it's not needed anymore
    delete options.type;

    // Initialize the picker
    const picker = new tempusDominus.TempusDominus($picker.get(0), options);
    $picker.data('picker', picker);

    // Update the theme when the theme changes
    document.addEventListener('theme:changed', () => {
        const theme = $('html').attr('data-bs-theme');

        // Hide the picker
        picker.hide();
        picker.updateOptions({ display: { theme: theme } });
    });
};
