/**
 * Initialize the turnstile captcha.
 *
 * @param {string} selector
 * @param {object} options
 * @see https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/
 */
return (selector, options = {}) => {
    const defaultOptions = {
        sitekey: $('meta[name="cloudflare-turnstile-site-key"]').attr('content'),
        theme: localStorage.getItem(window.themerKey) || 'light',
        language: $('html').attr('lang'),
        size: 'flexible',
    };

    const selectorOptions = getOptionsFromSelector(selector, 'captcha-');
    options = _.merge(defaultOptions, selectorOptions, options);

    // Define the callback function.
    options.callback = function (token) {
        $(selector).find('input').val(token);
    };

    const instance = turnstile.render(selector, options);

    // Set the instance on the input element.
    $(selector).data('captcha', instance);
};
