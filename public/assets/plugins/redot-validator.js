class RedotValidator {
    /**
     * Rules registered on the validator.
     */
    static rules = {};

    /**
     * Attribute name to be used in the DOM.
     */
    static attribute = 'validation';

    /**
     * Disable validation attribute name to be used in the DOM.
     */
    static disableAttribute = 'disable-validation';

    /**
     * Add a rule to the validator.
     */
    static addRule(name, callback) {
        this.rules[name] = callback;
    }

    /**
     * Get the errors for the given wrapper.
     */
    static errors(wrapper) {
        const errors = {};
        const selector = `[${this.attribute}]:not([${this.disableAttribute}])`;

        $(wrapper)
            .find(selector)
            .each((_index, field) => {
                const $field = $(field);
                const name = $field.attr('name');
                const fieldErrors = this.validateField(field, wrapper);

                if (Object.keys(fieldErrors).length > 0) {
                    errors[name] = fieldErrors;
                }
            });

        return errors;
    }

    /**
     * Validate the given wrapper.
     */
    static validate(wrapper) {
        return Object.keys(this.errors(wrapper)).length === 0;
    }

    /**
     * Validate the given field.
     */
    static validateField(field, wrapper = 'body') {
        const errors = {};

        const $field = $(field);
        const value = getFieldValue($field, wrapper);
        const rules = this.getRules($field);

        // Define the default type of the value
        let type = 'string';

        // Determine the type of the value
        if ($field.hasAttr(`${this.attribute}-type`)) {
            type = $field.attr(`${this.attribute}-type`);
        } else if (Array.isArray(value)) {
            type = 'array';
        } else if (rules.hasOwnProperty('numeric') || rules.hasOwnProperty('integer')) {
            type = 'numeric';
        } else if ($field.attr('type') === 'file') {
            type = 'file';
        } else if ($field.is('[init~="date-picker"]')) {
            type = 'date';
        }

        // If the field is nullable and the value is empty, skip it
        if (rules.nullable && Boolean(value) === false) {
            return {};
        }

        // If the field is nullable, remove the rule
        rules.nullable && delete rules.nullable;

        for (const [rule, params] of Object.entries(rules)) {
            // If the field has the skip attribute, skip it
            if ($field.attr('skip')) {
                $field.removeAttr('skip');

                return {};
            }

            const record = this.rules[rule];

            // If the rule doesn't exist, skip it
            if (!record || !record.callback) {
                continue;
            }

            const callback = this.rules[rule].callback;
            const message = this.rules[rule].message;

            // Try to get the label from the field's attributes
            const attributes = ['label', 'title', 'aria-label'];
            let label = attributes.reduce((label, attribute) => $field.attr(attribute) || label, '');

            // If the label is empty, try to get it from the field's label
            if (label === '' && $(wrapper).find(`label[for="${$field.attr('id')}"]`).length) {
                const $label = $(wrapper).find(`label[for="${$field.attr('id')}"]`);

                // Sanitize the label from any special characters
                label = $label.attr('aria-label') || $label.text().replace(/[^a-zA-Z0-9\s]/g, '');
            }

            // Trim the label and convert it to lowercase
            label = label.trim().toLowerCase();

            // Prepare the arguments for the callback
            const name = $field.attr('name');
            const args = { value, params, rules, name, label, field: $field, type };

            // If the rule doesn't pass, add the error
            if (callback(_.cloneDeep(args)) === false) {
                let errorMessage = '';

                if ($field.attr(`${this.attribute}-${rule}-message`)) {
                    errorMessage = $field.attr(`${this.attribute}-${rule}-message`);
                } else if (typeof message === 'function') {
                    errorMessage = message(_.cloneDeep(args));
                }

                errors[rule] = errorMessage;
            }
        }

        return errors;
    }

    /**
     * Get the rules for the given field.
     */
    static getRules(field) {
        let rules = this.safeSplit($(field).attr(this.attribute), '|');

        return rules.reduce((rules, rule) => {
            let [name, params] = rule.split(/:(.+)/);

            name = name.trim();
            params = this.safeSplit(params, ',').map((param) => stringToPrimitive(param.trim()));

            return { ...rules, [name]: params };
        }, {});
    }

    /**
     * Safe split a string.
     */
    static safeSplit(str, delimiter = ',') {
        if (typeof str !== 'string' || str === '') {
            return [];
        }

        const placeholder = _.uniqueId('%placeholder') + '%';
        const regex = /(\/.*?\/) ?(?:\||\,|$)/g;

        str = str.replace(regex, function (str, match) {
            return str.trim().replace(match, match.replaceAll(delimiter, placeholder));
        });

        return str.split(delimiter).map(function (str) {
            return str.trim().replaceAll(placeholder, delimiter);
        });
    }
}
