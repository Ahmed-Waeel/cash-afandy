/**
 * The following props are passed to the callback and message functions:
 *
 * - value: The value of the field
 * - params: The parameters passed to the rule
 * - rules: The rules tree that applied to the field
 * - name: The name attribute of the field
 * - label: Safe name to display in the error message
 * - field: The jQuery field object
 * - type: The type of the field (array, numeric, file, date, string)
 */

RedotValidator.addRule('accepted', {
    callback: function ({ value }) {
        return ['yes', 'on', 1, '1', true, 'true'].includes(String(value).toLowerCase());
    },
    message: function ({ label }) {
        return __('validation.accepted', { attribute: label });
    },
});

RedotValidator.addRule('accepted_if', {
    callback: function ({ value, params, field }) {
        const [other, otherValue] = params;

        if (checkOtherField(field, other, otherValue)) {
            return RedotValidator.rules.accepted.callback({ value });
        }

        return true;
    },
    message: function ({ label, params }) {
        const [other, otherValue] = params;

        return __('validation.accepted_if', {
            attribute: label,
            other: other,
            value: otherValue,
        });
    },
});

RedotValidator.addRule('required', {
    callback: function ({ value, type }) {
        if (type === 'array') {
            return value.length > 0;
        }

        if (typeof value === 'object' && value !== null) {
            return Object.keys(value).length > 0;
        }

        return Boolean(value);
    },
    message: function ({ label }) {
        return __('validation.required', { attribute: label });
    },
});

RedotValidator.addRule('required_visible', {
    callback: function ({ value, field }) {
        if (field.is(':visible') === false) {
            // Add a skip attribute to the field to prevent it from being validated
            field.attr('skip', true);

            return true;
        }

        return RedotValidator.rules.required.callback({ value });
    },
    message: function ({ label }) {
        return __('validation.required', { attribute: label });
    },
});

RedotValidator.addRule('required_if', {
    callback: function ({ value, params, field }) {
        const [other, otherValue] = params;

        if (checkOtherField(field, other, otherValue)) {
            return RedotValidator.rules.required.callback({ value });
        }

        return true;
    },
    message: function ({ label, params }) {
        const [other, otherValue] = params;

        return __('validation.required_if', { attribute: label, other, value: otherValue });
    },
});

RedotValidator.addRule('required_unless', {
    callback: function ({ value, params, field }) {
        const [other, otherValue] = params;

        if (checkOtherField(field, other, otherValue)) {
            return true;
        }

        return RedotValidator.rules.required.callback({ value });
    },
    message: function ({ label, params }) {
        const [other, otherValue] = params;

        return __('validation.required_unless', { attribute: label, other, values: otherValue });
    },
});

RedotValidator.addRule('min', {
    callback: function ({ field, value, params, type }) {
        const [min] = params;

        if (type === 'array') {
            return value.length >= min;
        }

        if (type === 'numeric') {
            return value >= min;
        }

        if (type === 'file') {
            const files = Array.from(field.get(0).files);

            return files.every((file) => file.size >= min * 1024);
        }

        return String(value).trim().length >= min;
    },
    message: function ({ params, label, type }) {
        const [min] = params;

        if (type === 'array') {
            return __('validation.min.array', { attribute: label, min });
        }

        if (type === 'numeric') {
            return __('validation.min.numeric', { attribute: label, min });
        }

        if (type === 'file') {
            return __('validation.min.file', { attribute: label, min });
        }

        return __('validation.min.string', { attribute: label, min });
    },
});

RedotValidator.addRule('max', {
    callback: function ({ field, value, params, type }) {
        const [max] = params;

        if (type === 'array') {
            return value.length <= max;
        }

        if (type === 'numeric') {
            return value <= max;
        }

        if (type === 'file') {
            const files = Array.from(field.get(0).files);

            return files.every((file) => file.size <= max * 1024);
        }

        return String(value).trim().length <= max;
    },
    message: function ({ params, label, type }) {
        const [max] = params;

        if (type === 'array') {
            return __('validation.max.array', { attribute: label, max });
        }

        if (type === 'numeric') {
            return __('validation.max.numeric', { attribute: label, max });
        }

        if (type === 'file') {
            return __('validation.max.file', { attribute: label, max });
        }

        return __('validation.max.string', { attribute: label, max });
    },
});

RedotValidator.addRule('between', {
    callback: function (args) {
        let [min, max] = args.params;

        return (
            RedotValidator.rules.min.callback({ ...args, params: [min] }) &&
            RedotValidator.rules.max.callback({ ...args, params: [max] })
        );
    },
    message: function ({ params, label, type }) {
        const [min, max] = params;

        if (type === 'array') {
            return __('validation.between.array', { attribute: label, min, max });
        }

        if (type === 'numeric') {
            return __('validation.between.numeric', { attribute: label, min, max });
        }

        return __('validation.between.string', { attribute: label, min, max });
    },
});

RedotValidator.addRule('size', {
    callback: function ({ field, value, params, type }) {
        const [size] = params;

        if (type === 'array') {
            return value.length === size;
        }

        if (type === 'numeric') {
            return value === size;
        }

        if (type === 'file') {
            const files = Array.from(field.get(0).files);

            return files.every((file) => file.size === size * 1024);
        }

        return String(value).trim().length === size;
    },
    message: function ({ params, label, type }) {
        const [size] = params;

        if (type === 'array') {
            return __('validation.size.array', { attribute: label, size });
        }

        if (type === 'numeric') {
            return __('validation.size.numeric', { attribute: label, size });
        }

        if (type === 'file') {
            return __('validation.size.file', { attribute: label, size });
        }

        return __('validation.size.string', { attribute: label, size });
    },
});

RedotValidator.addRule('email', {
    callback: function ({ value }) {
        return /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g.test(value);
    },
    message: function ({ label }) {
        return __('validation.email', { attribute: label });
    },
});

RedotValidator.addRule('url', {
    callback: function ({ value }) {
        try {
            new URL(value);
            return true;
        } catch (error) {
            return false;
        }
    },
    message: function ({ label }) {
        return __('validation.url', { attribute: label });
    },
});

RedotValidator.addRule('alpha', {
    callback: function ({ value }) {
        return /^[a-zA-Z]+$/g.test(value);
    },
    message: function ({ label }) {
        return __('validation.alpha', { attribute: label });
    },
});

RedotValidator.addRule('alpha_num', {
    callback: function ({ value }) {
        return /^[a-zA-Z0-9]+$/g.test(value);
    },
    message: function ({ label }) {
        return __('validation.alpha_num', { attribute: label });
    },
});

RedotValidator.addRule('alpha_dash', {
    callback: function ({ value }) {
        return /^[a-zA-Z0-9_-]+$/g.test(value);
    },
    message: function ({ label }) {
        return __('validation.alpha_dash', { attribute: label });
    },
});

RedotValidator.addRule('starts_with', {
    callback: function ({ value, params }) {
        return params.some((param) => value.startsWith(param));
    },
    message: function ({ label, params }) {
        return __('validation.starts_with', { attribute: label, values: params.join(', ') });
    },
});

RedotValidator.addRule('ends_with', {
    callback: function ({ value, params }) {
        return params.some((param) => value.endsWith(param));
    },
    message: function ({ label, params }) {
        return __('validation.ends_with', { attribute: label, values: params.join(', ') });
    },
});

RedotValidator.addRule('enum', {
    callback: function ({ value, params }) {
        return params.some((param) => param == value);
    },
    message: function ({ label, params }) {
        return __('validation.enum', { attribute: label, values: params.join(', ') });
    },
});

RedotValidator.addRule('lowercase', {
    callback: function ({ value }) {
        return value.toLowerCase() === value;
    },
    message: function ({ label }) {
        return __('validation.lowercase', { attribute: label });
    },
});

RedotValidator.addRule('uppercase', {
    callback: function ({ value }) {
        return value.toUpperCase() === value;
    },
    message: function ({ label }) {
        return __('validation.uppercase', { attribute: label });
    },
});

RedotValidator.addRule('numeric', {
    callback: function ({ value }) {
        return /^[0-9]+$/g.test(value);
    },
    message: function ({ label }) {
        return __('validation.numeric', { attribute: label });
    },
});

RedotValidator.addRule('integer', {
    callback: function ({ value }) {
        return value % 1 === 0;
    },
    message: function ({ label }) {
        return __('validation.integer', { attribute: label });
    },
});

RedotValidator.addRule('decimal', {
    callback: function ({ value }) {
        return value % 1 !== 0;
    },
    message: function ({ label }) {
        return __('validation.decimal', { attribute: label });
    },
});

RedotValidator.addRule('in', {
    callback: function ({ value, params }) {
        value = Array.isArray(value) ? value : [value];

        return value.every((val) => params.includes(val));
    },
    message: function ({ label, params }) {
        return __('validation.in', { attribute: label, values: params.join(', ') });
    },
});

RedotValidator.addRule('not_in', {
    callback: function ({ value, params }) {
        value = Array.isArray(value) ? value : [value];

        return value.some((val) => params.includes(val)) === false;
    },
    message: function ({ label, params }) {
        return __('validation.not_in', { attribute: label, values: params.join(', ') });
    },
});

RedotValidator.addRule('contains', {
    callback: function ({ value, params }) {
        value = Array.isArray(value) ? value : [value];

        return params.every((val) => value.includes(val));
    },
    message: function ({ label, params }) {
        return __('validation.contains', { attribute: label, values: params.join(', ') });
    },
});

RedotValidator.addRule('confirmed', {
    callback: function ({ value, name, field }) {
        const confirmation = field.closest('form').find(`[name="${name}_confirmation"]`).val();

        return value === confirmation;
    },
    message: function ({ label }) {
        return __('validation.confirmed', { attribute: label });
    },
});

RedotValidator.addRule('regex', {
    callback: function ({ value, params }) {
        let [regex] = params;
        regex = regex.replace(/^\/|\/$/g, '');

        return new RegExp(regex).test(value);
    },
    message: function ({ label }) {
        return __('validation.regex', { attribute: label });
    },
});
