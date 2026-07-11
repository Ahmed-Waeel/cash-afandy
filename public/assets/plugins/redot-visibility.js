class RedotVisibility {
    /**
     * The instance of the plugin.
     */
    static instance = null;

    /**
     * The selector to use to find the elements to toggle.
     */
    selector = 'visible-when';

    /**
     * The pattern to use to find the selectors in the statements.
     */
    selectorPattern = /\$([^\s.]+)/g;

    /**
     * Elements that are being watched.
     */
    elements = new Set();

    /**
     * Create a new instance.
     */
    constructor() {
        if (RedotVisibility.instance !== null) {
            return RedotVisibility.instance;
        }

        RedotVisibility.instance = this;

        this.watch();
    }

    /**
     * Initialize the visibility plugin.
     */
    static init() {
        return new RedotVisibility();
    }

    /**
     * Update the visibility of the elements.
     */
    update() {
        $(`[${this.selector}]`).each((_, element) => {
            const $element = $(element);

            const statement = $element.attr(this.selector);
            const visibility = Boolean(this.evaluate(statement));

            $element.attr('is-visible', visibility);
            $element.toggle(visibility);

            // Disable validation on hidden elements
            $element.find('input, select, textarea').each((_, el) => {
                const $el = $(el);

                // Add the attribute to the element
                $el.attr('is-visible', visibility);

                // Early return if the form has `keep-hidden` attribute
                if ($element.closest('form').hasAttr('keep-hidden')) {
                    return;
                }

                if (visibility) {
                    $el.removeAttr('disabled');
                    $el.removeAttr(RedotValidator.disableAttribute);
                } else {
                    $el.attr('disabled', true);
                    $el.attr(RedotValidator.disableAttribute, true);
                }

                $el.trigger('visibility:updated', visibility);
            });

            $element.trigger('visibility:updated', visibility);
        });
    }

    /**
     * Evaluate the statement.
     */
    evaluate(statement) {
        let processed = statement;

        // Replace the pattern with the value of the selector
        processed = statement.replace(this.selectorPattern, (_, selector) => {
            return JSON.stringify(getFieldValue($.query(selector)));
        });

        try {
            return new Function(`return ${processed}`)();
        } catch (e) {
            console.error('Error evaluating statement:', e);
            return false;
        }
    }

    /**
     * Watch for changes on the selectors.
     */
    watch() {
        const pattern = this.selectorPattern;

        $(`[${this.selector}]`).each((_, el) => {
            const statement = $(el).attr(this.selector);
            const selectors = [...statement.matchAll(new RegExp(pattern.source, 'g'))] || [];

            selectors.forEach((selector) => {
                selector = selector[1];
                let $element = $.query(selector);

                // If the selector is not found, return
                if ($element.length === 0) return;

                // Early return if the selector is already being watched
                if (this.elements.has(selector)) return;

                // Add the selector to the elements
                this.elements.add(selector);

                // Add the event listener to the element
                $element.on('change input', () => this.update());
            });
        });

        this.update();
    }
}
