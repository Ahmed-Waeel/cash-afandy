/* ---------------------------------
 * jQuery Extensions
 * --------------------------------- */

if (typeof window.$ !== 'undefined') {
    $.fn.extend({
        /**
         * Check if the given element has the given attribute.
         *
         * @param {string} name
         * @returns {boolean}
         */
        hasAttr: function (name) {
            let $element = this;

            // Early return if the element is not found
            if ($element.length === 0) {
                return false;
            }

            return $element.get(0).hasAttribute(name);
        },
    });

    /**
     * Query the given selector.
     *
     * @param {string} selector
     * @param {string|object} context
     * @returns {object}
     */
    window.$.query = function (selector, context = document) {
        // Get the context jQuery object
        const $context = context instanceof jQuery ? context : $(context);

        // Early return if the selector is already a jQuery object
        if (selector instanceof jQuery) return selector;

        let patterns = [
            selector,
            `#${selector}`,
            `.${selector}`,
            `[name="${selector}"]`,
            `[name^="${selector}"]`,
            `[${selector}]`,
        ];

        try {
            for (const pattern of patterns) {
                if ($context.find(pattern).length) {
                    return $context.find(pattern);
                }
            }
        } catch (error) {
            // ...
        }

        return $(selector);
    };
}

/* ---------------------------------
 * Translations
 * --------------------------------- */

/**
 * Translate the given key with the given parameters.
 *
 * @param {string} key
 * @param {object} params
 * @returns {string}
 */
function __(key, params = {}) {
    if (typeof window.__translations === 'undefined') {
        return key;
    }

    let translation = window.__translations[key] || key;

    for (const [param, value] of Object.entries(params)) {
        translation = translation.replaceAll(`:${param}`, value);
    }

    return translation;
}

/* ---------------------------------
 * Type & Value Helpers
 * --------------------------------- */

/**
 * Check if the given value is JSON.
 *
 * @param {string} value
 * @returns {boolean}
 */
function isJson(value) {
    try {
        JSON.parse(value);
    } catch (error) {
        return false;
    }

    return true;
}

/**
 * Convert the given string to a primitive value.
 *
 * @param {string} string
 * @returns any
 */
function stringToPrimitive(string) {
    const primitives = {
        true: true,
        false: false,
        null: null,
        undefined: undefined,
    };

    // If the value is a primitive, return it.
    if (string in primitives) return primitives[string];

    // If the value is a property of the window object, return it.
    if (string.startsWith('window.')) return _.get(window, string.replace('window.', ''), string);

    // If the value starts with `return`, evaluate it and return the result.
    if (string.startsWith('return ')) return new Function(string)();

    // If the value is a numeric string, return it.
    if (string.match(/^-?\d+$/)) return Number(string);

    // Try to parse the value as JSON and return it.
    return isJson(string) ? JSON.parse(string) : string;
}

/**
 * Slugify the given string.
 *
 * @param {string} string
 * @param {object} options
 * @returns {string}
 */
function slugify(string, options = {}) {
    const defaultOptions = {
        replacement: '-',
        remove: undefined,
        lower: true,
        strict: false,
        trim: true,
    };

    const opts = {
        ...defaultOptions,
        ...options,
    };

    let slug = string.normalize().replace(opts.remove, '').replace(/\s+/g, ' ');

    if (opts.strict) {
        slug = slug.replace(/[^A-Za-z0-9\s]/g, '');
    }

    if (opts.trim) {
        slug = slug.trim();
    }

    slug = slug.replace(/\s+/g, opts.replacement);

    if (opts.lower) {
        slug = slug.toLowerCase();
    }

    return slug;
}

/* ---------------------------------
 * Confirmation Dialogs
 * --------------------------------- */

/**
 * Show a confirmation dialog before executing the given action.
 *
 * @param {function} action
 * @param {object} options
 */
function warnBeforeAction(action, options = {}) {
    const defaultOptions = {
        type: 'red',
        title: __('Are you sure?'),
        content: __('This action cannot be undone.'),
        escapeKey: true,
        backgroundDismiss: true,
        buttons: {
            cancel: {
                text: __('No'),
                btnClass: 'btn btn-secondary',
            },
            confirm: {
                text: __('Yes'),
                btnClass: 'btn-primary',
                action: function () {
                    return action.call(this);
                },
            },
        },
    };

    $.confirm(_.merge(defaultOptions, options));
}

/**
 * Wait for the user to confirm the given message.
 *
 * @param {object} options
 */
function awaitConfirmation(options = {}) {
    return new Promise((resolve, reject) => {
        const defaultOptions = {
            type: 'blue',
            escapeKey: true,
            backgroundDismiss: true,
            buttons: {
                cancel: {
                    text: __('No'),
                    btnClass: 'btn btn-secondary',
                    action: function () {
                        return reject();
                    },
                },
                confirm: {
                    text: __('Yes'),
                    btnClass: 'btn-primary',
                    action: function () {
                        return resolve();
                    },
                },
            },
        };

        $.confirm(_.merge(defaultOptions, options));
    });
}

/* ---------------------------------
 * Form Validation
 * --------------------------------- */

/**
 * Validate the given form.
 *
 * @param {object} $form
 * @returns {boolean}
 */
function validateForm($form, verbose = false) {
    const errors = RedotValidator.errors($form);

    // No errors, submit the form
    if (Object.keys(errors).length === 0) {
        return true;
    }

    // Append the errors to the form if verbose mode is enabled
    if (verbose) {
        appendErrorsToForm($form, errors);
        scrollToFirstError($form);
    }

    return false;
}

/**
 * Append the given errors to the given form.
 *
 * @param {object} $form
 * @param {object} errors
 * @returns {void}
 */
function appendErrorsToForm($form, errors = {}) {
    $form.find('.invalid-feedback').remove();
    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('.has-invalid-feedback').removeClass('has-invalid-feedback');

    for (const [key, value] of Object.entries(errors)) {
        const normalizedKey = key.replace(/\.([^\.]+)/g, '[$1]');
        const possibleKeys = [key, `${key}[]`, normalizedKey, `${normalizedKey}[]`];

        let $input = $form.find(possibleKeys.map((key) => `[name="${key}"]`).join(', '));

        // If the input is not found, try to find it by the validation key.
        if ($input.length === 0) {
            $form.find(`[validation-key]`).each(function () {
                const key = $(this).attr('validation-key');

                if (possibleKeys.includes($(this).attr(key))) {
                    $input = $(this);
                }
            });
        }

        let $container = null;

        if ($input.attr('validation-container')) {
            $container = $($input.attr('validation-container'));
        } else if ($form.attr('validation-container')) {
            $container = $($form.attr('validation-container'));
        } else {
            $container = $input.parent();
        }

        const $feedback = $(`<div class="invalid-feedback"></div>`);

        $input.addClass('is-invalid');
        $container.addClass('has-invalid-feedback').append($feedback);

        let messages = Object.values(value);
        let message = messages.shift();

        if (messages.length) {
            // If there are more than one error, add a counter for the remaining errors
            message += ' ' + __('(and :count more error)', { count: messages.length });
        }

        $feedback.html(`<strong>${message}</strong>`);

        if ($input.closest('.input-group').length) {
            $input.closest('.input-group').addClass('has-invalid-feedback');
        }

        $input.parents('.tab-pane').each(function () {
            const tabpane = $(this).attr('id');
            $(`[href="#${tabpane}"]`).addClass('has-invalid-feedback');
        });
    }
}

function scrollToFirstError($form) {
    // Get the first error element
    const $firstError = $form.find('.is-invalid').first();

    // Early return if the first error element is not found
    if ($firstError.length === 0) return;

    // Early return if the form has the attribute 'dont-scroll-to-error'
    if ($form.hasAttr('dont-scroll-to-error')) return;

    // Show the tab containing the first error element
    $firstError.parents('.tab-pane').each(function () {
        const tabpane = $(this).attr('id');
        $(`[href="#${tabpane}"]`).tab('show');
    });

    // Scroll to the first error element
    $firstError.get(0).scrollIntoView({
        behavior: 'smooth',
        block: 'center',
    });

    // Early return if the form has the attribute 'dont-toast'
    if ($form.hasAttr('dont-toast')) return;

    toastify().error(__('You have errors in your form. Please correct them and try again.'));
}

/* ---------------------------------
 * Form Fields
 * --------------------------------- */

/**
 * Serialize the given fields.
 *
 * @param {object} $fields
 * @returns {object}
 */
function serializeFields($fields, key = 'name') {
    const data = {};

    $fields.find(`[${key}]`).each(function () {
        const identifier = $(this).attr(key).replace(/\[\]$/, '');

        // Set the field value to the data object.
        _.set(data, identifier, getFieldValue($(this), $fields, key));
    });

    return data;
}

/**
 * Get the value of the given field.
 *
 * @param {object} $field
 * @param {object} form
 * @param {string} key
 * @returns any
 */
function getFieldValue($field, form = 'body', key = 'name') {
    const type = $field.attr('type');
    const identifier = $field.attr(key);

    if (type === 'checkbox' && $field.closest('.form-switch').length) {
        return $field.is(':checked');
    }

    if (type === 'checkbox') {
        const checked = $(form).find(`[${key}="${identifier}"]:checked`);
        return checked.map((i, el) => $(el).val()).get();
    }

    if (type === 'radio') {
        return $(form).find(`[${key}="${identifier}"]:checked`).val() || null;
    }

    if (type === 'number' && $field.hasAttr('as-text') === false) {
        return +$field.val();
    }

    if (window.tinymce && tinymce.get($field.attr('id'))) {
        return tinymce.get($field.attr('id')).getContent();
    }

    if ($field.data('uploader')) {
        return $field.data('uploader').getFiles();
    }

    return $field.val();
}

/**
 * Deserialize the given data to the given fields.
 *
 * @param {object} $fields
 * @param {object} data
 * @returns {void}
 */
function deserializeFields($fields, data = {}, key = 'name') {
    $fields.find(`[${key}]`).each(function () {
        const $field = $(this);
        const identifier = $(this).attr(key).replace(/\[\]$/, '');
        const value = _.get(data, identifier);

        // Early return if the value is not found.
        if (typeof value === 'undefined') {
            return;
        }

        setFieldValue($field, value, $fields, key);

        // Trigger the change event after setting the value.
        $field.trigger('change');
    });
}

/**
 * Set the value of the given field.
 *
 * @param {object} $field
 * @param {any} value
 * @param {object} form
 * @param {string} key
 * @returns {void}
 */
function setFieldValue($field, value, form = 'body', key = 'name') {
    const type = $field.attr('type');
    const identifier = $field.attr(key);

    // Early return if the field is a file input.
    if (type === 'file') {
        return;
    }

    if (type === 'checkbox' && $field.closest('.form-switch').length) {
        return $field.prop('checked', value);
    }

    if (type === 'checkbox') {
        const checked = _.castArray(value);
        const checkboxes = $(form).find(`[${key}="${identifier}"]`);

        // Uncheck all checkboxes before checking the selected ones.
        checkboxes.prop('checked', false);

        return checkboxes.filter((i, el) => checked.includes($(el).val())).prop('checked', true);
    }

    if (type === 'radio') {
        return $(form).find(`[${key}="${identifier}"][value="${value}"]`).prop('checked', true);
    }

    if (type === 'number') {
        return $field.val(+value);
    }

    if ($field.is('select')) {
        if ($field.hasAttr('select-query')) {
            return $field.attr('select-preload-values', Array.isArray(value) ? value.join(',') : value);
        }

        if (value === null || value === '') {
            return $field.val(null);
        }

        // Convert the value to an array if it's not already one.
        value = Array.isArray(value) ? value : value.toString().split(',');

        // Set the selected values for the select element.
        for (const val of value) {
            $field.find(`option[value="${val}"]`).attr('selected', true);
        }

        // Set the value for the tom select element.
        if ($field.data('tomselect')) {
            $field.data('tomselect').setValue(value);
        }

        return $field.val(value);
    }

    if (window.tinymce && tinymce.get($field.attr('id'))) {
        return tinymce.get($field.attr('id')).setContent(value);
    }

    if ($field.data('repeater')) {
        return $field.data('repeater').set(value);
    }

    if ($field.data('uploader')) {
        return $field.data('uploader').setFiles(value);
    }

    if ($field.data('picker')) {
        return $field.data('picker').dates.setFromInput(value);
    }

    return $field.val(value);
}

/**
 * Check if the other field matches the given value.
 *
 * @param {jQuery} field
 * @param {string} other
 * @param {any} otherValue
 * @returns {boolean}
 */
function checkOtherField(field, other, otherValue) {
    let $form = field.closest('form');

    // Fallback to body if the form is not found
    if ($form.length === 0) {
        $form = $('body');
    }

    // Check if the other field inside a repeater item
    if (field.closest('[repeater-item]').length) {
        const item = field.closest('[repeater-item]');
        const otherField = item.find(`[initial-name^="${other}"]`);

        if (otherField.length) {
            return otherField.val() == otherValue;
        }
    }

    if ($form.find(`[name="${other}"]`).length) {
        return $form.find(`[name="${other}"]`).val() == otherValue;
    }

    return false;
}

/* ---------------------------------
 * DOM & UI Utilities
 * --------------------------------- */

/**
 * Make the given element draggable.
 *
 * @param {string} selector
 * @param {number} minDiff
 */
function makeDraggable(selector, minDiff = 5) {
    const $target = $(selector);

    let isMouseDown = false,
        lastX,
        lastY;

    $target.on('mousedown', (e) => {
        isMouseDown = true;
        lastX = e.pageX;
        lastY = e.pageY;
    });

    $target.on('mouseup mouseleave', () => {
        isMouseDown = false;

        $target.removeClass('dragging');
        $target.css('cursor', 'initial');
    });

    $target.on('mousemove', (e) => {
        if (!isMouseDown) {
            return;
        }

        let diffX = e.pageX - lastX;
        let diffY = e.pageY - lastY;

        $target.addClass('dragging');
        $target.css('cursor', 'grabbing');

        if (Math.abs(diffX) > minDiff || Math.abs(diffY) > minDiff) {
            $target.scrollLeft($target.scrollLeft() - diffX);
            $target.scrollTop($target.scrollTop() - diffY);
            lastX = e.pageX;
            lastY = e.pageY;
        }
    });
}

/**
 * Send a form request to the given URL.
 *
 * @param {string} url
 * @param {object} data
 * @param {string} method
 */
function formRequest(url, data = {}, method = 'POST') {
    const $form = $('<form>', {
        method: method.toUpperCase() === 'GET' ? 'GET' : 'POST',
        action: url,
    });

    $form.append($('<input>', { type: 'hidden', name: '_token', value: $('meta[name="csrf-token"]').attr('content') }));
    $form.append($('<input>', { type: 'hidden', name: '_method', value: method }));

    for (const [key, value] of Object.entries(data)) {
        $form.append($('<input>', { type: 'hidden', name: key, value: value }));
    }

    $form.appendTo('body').submit();
}

/**
 * Copy the given text to the clipboard.
 *
 * @param {string} text
 */
function copyToClipboard(text) {
    return navigator.clipboard.writeText(text);
}

/**
 * Toggle fullscreen mode for the given element.
 *
 * @param {string} selector
 */
function toggleFullscreen(selector = 'html', className = 'fullscreen') {
    document.requestFullscreen = document.requestFullscreen || document.webkitRequestFullscreen;
    document.fullscreenElement = document.fullscreenElement || document.webkitFullscreenElement;
    document.exitFullscreen = document.exitFullscreen || document.webkitExitFullscreen;

    if (document.fullscreenElement) {
        document.exitFullscreen();
        $(selector).removeClass(className);
    } else {
        $(selector).addClass(className);
        $(selector).get(0).requestFullscreen();
    }
}

/**
 * Apply selected files to the given avatar.
 *
 * @param {string} source
 * @param {string} target
 * @returns {void}
 */
function applyAvatarPreview(source, target) {
    const $input = $(source);
    const $preview = $(target);
    const reader = new FileReader();

    reader.addEventListener('load', () => {
        $preview.css({
            backgroundImage: `url(${reader.result})`,
        });

        $preview.empty();
    });

    reader.readAsDataURL($input.get(0).files[0]);
}

/* ---------------------------------
 * Date & Time
 * --------------------------------- */

/**
 * Format the given date as a localized relative time (e.g. "5 minutes ago").
 *
 * @param {string|number|Date} date
 * @param {object} options
 * @returns {string}
 */
function relativeTime(date, options = {}) {
    const locale = options.locale || document.documentElement.lang || 'en';

    const formatter = new Intl.RelativeTimeFormat(locale, {
        numeric: options.numeric || 'always',
        style: options.style || 'long',
    });

    const units = [
        ['year', 31536000],
        ['month', 2592000],
        ['week', 604800],
        ['day', 86400],
        ['hour', 3600],
        ['minute', 60],
        ['second', 1],
    ];

    const seconds = Math.max(1, Math.round((Date.now() - new Date(date).getTime()) / 1000));

    for (const [unit, size] of units) {
        if (seconds >= size || unit === 'second') {
            return formatter.format(-Math.round(seconds / size), unit);
        }
    }
}

/**
 * Keep every [relative-time] element within the root updated in realtime.
 *
 * @param {HTMLElement} root
 * @param {object} options
 * @returns {number} The interval id, so it can be cleared by the caller.
 */
function liveRelativeTimes(root = document.body, options = {}) {
    const update = () => {
        root.querySelectorAll('time[relative-time]').forEach((element) => {
            const datetime = element.getAttribute('datetime');

            if (datetime) {
                element.textContent = relativeTime(datetime, options);
            }
        });
    };

    update();

    return setInterval(update, options.interval || 1000);
}

/* ---------------------------------
 * Initialization
 * --------------------------------- */

/**
 * Initialize the given initiators.
 *
 * @param {string} selector
 */
function init(selector = 'body') {
    const $selector = $(selector).attr('init') ? $(selector).parent() : $(selector);

    // Initialize non-initialized initiators.
    $selector.find('[init]:not([initialized])').each(function () {
        let inits = $(this).attr('init').split(' ');

        // Trigger before all initiators.
        $selector.trigger('init.before');

        for (const init of inits) {
            if (!window.__inits[init]) {
                console.error(`Initiator "${init}" is not defined.`);
                continue;
            }

            // Trigger before the initiator.
            $selector.trigger(`init.before.${init}`);

            const options = this.hasAttribute(init) ? stringToPrimitive($(this).attr(init)) : {};
            window.__inits[init](this, options); // Call the initiator with the given options.

            // Trigger after the initiator.
            $selector.trigger(`init.after.${init}`);
        }

        // Trigger after all initiators.
        $selector.trigger('init.after');

        $(this).attr('initialized', true);
    });

    // Watch for visibility changes.
    if (RedotVisibility.instance) RedotVisibility.instance.watch();
}

/**
 * Get the options from the given selector.
 *
 * @param {string} selector
 * @param {string} prefix
 * @param {boolean} camelCase
 * @returns {object}
 */
function getOptionsFromSelector(selector, prefix, camelCase = true) {
    const attributes = $(selector).get(0).attributes;
    const options = {};

    for (const attribute of attributes) {
        if (!attribute.name.startsWith(prefix)) {
            continue;
        }

        let key = attribute.name.replace(prefix, '');
        let value = stringToPrimitive(attribute.value);

        // Convert the key to camel case if needed.
        if (camelCase) key = key.replace(/-([a-z])/g, (g) => g[1].toUpperCase());

        _.set(options, key, value);
    }

    return options;
}
