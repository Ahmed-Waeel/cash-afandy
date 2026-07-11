class RedotIconPicker {
    /**
     * The input element that binds the icon picker.
     */
    $input;

    /**
     * The wrapper element that contains the icon picker components.
     */
    $wrapper;

    /**
     * The preview element that shows the selected icon.
     */
    $preview;

    /**
     * The picker button element that opens the modal.
     */
    $picker;

    /**
     * Default options for the icon picker.
     */
    options = {
        /**
         * The FontAwesome API endpoint.
         */
        endpoint: 'https://api.fontawesome.com',

        /**
         * The FontAwesome version to use.
         */
        version: '6.4.2',

        /**
         * The maximum number of icons to fetch.
         */
        maxResults: 100,

        /**
         * Debounce delay for search input.
         */
        searchDebounce: 100,

        /**
         * The repeater attributes that will be used to identify the elements.
         */
        attributes: {
            template: 'iconpicker-template',
            modal: 'iconpicker-modal',
            search: 'iconpicker-search',
            list: 'iconpicker-list',
            icon: 'iconpicker-icon',
            empty: 'iconpicker-empty',
            loading: 'iconpicker-loading',
        },
    };

    /**
     * Create a new instance.
     */
    constructor(selector, options = {}) {
        this.options = _.merge(this.options, options);

        this.$input = $(selector);
        this.$wrapper = this.$input.closest('[iconpicker-wrapper]');
        this.$preview = this.$wrapper.find('[iconpicker-preview]');
        this.$picker = this.$wrapper.find('[iconpicker-picker]');

        this.init();
    }

    /**
     * Initialize the icon picker.
     */
    init() {
        this.bindEvents();
        this.$input.trigger('change');
    }

    /**
     * Bind events to the icon picker elements.
     */
    bindEvents() {
        this.$input.on('change input', () => {
            this.updatePreview();
        });

        this.$picker.on('click', () => {
            this.openModal();
        });
    }

    /**
     * Update the preview icon based on input value.
     */
    updatePreview() {
        this.$preview.attr('class', `icon icon-sm ${this.$input.val()}`);
    }

    /**
     * Open the icon picker modal.
     */
    openModal() {
        const self = this;
        const attrs = self.options.attributes;

        $.confirm({
            container: this.$wrapper,
            icon: 'far fa-font-awesome me-2',
            title: __('Select an icon'),
            content: `<div ${attrs.modal}>${$(`[${attrs.template}]`).html()}</div>`,
            onOpenBefore: function () {
                self.bindModalEvents(this.$content);
                self.searchIcons(this.$content);
            },
            buttons: {
                cancel: {
                    text: __('Cancel'),
                    btnClass: 'btn-secondary',
                },
                confirm: {
                    text: __('Select'),
                    btnClass: 'btn-primary',
                    action: function () {
                        self.saveSelection(this.$content);
                    },
                },
            },
        });
    }

    /**
     * Bind events to the icon picker modal.
     */
    bindModalEvents($content) {
        const attrs = this.options.attributes;

        $content.find(`[${attrs.search}]`).on(
            'keyup',
            _.debounce((event) => {
                const term = event.target.value.trim();
                this.searchIcons($content, term);
            }, this.options.searchDebounce),
        );

        $content.on('click', `[${attrs.icon}]`, function () {
            $content.find(`[${attrs.icon}]`).removeClass('selected');
            $(this).addClass('selected');
        });
    }

    /**
     * Search for icons using the FontAwesome API.
     */
    async searchIcons($content, term = '') {
        const attrs = this.options.attributes;

        // Show the loading state.
        $content.find(`[${attrs.loading}]`).show();
        $content.find(`[${attrs.empty}]`).hide();

        const query = `query {
            search(version: "${this.options.version}", query: "${term}", first: ${this.options.maxResults}) {
                id,
                familyStylesByLicense {
                    free {
                        family,
                        style
                    }
                }
            }
        }`;

        try {
            const response = await fetch(`${this.options.endpoint}/?query=${query}`);
            const data = await response.json();

            this.populateIcons($content, data.data.search);
        } catch (error) {
            console.error('Error fetching icons:', error);
            this.showError($content);
        }

        // Hide the loading state.
        $content.find(`[${attrs.loading}]`).hide();
    }

    /**
     * Populate the icon picker modal with icons.
     */
    populateIcons($content, icons) {
        const attrs = this.options.attributes;

        $content.find(`[${attrs.icon}]`).remove();

        for (const icon of icons) {
            // Skip if the icon has no free styles.
            if (icon.familyStylesByLicense.free.length === 0) {
                continue;
            }

            const style = icon.familyStylesByLicense.free[0].style;
            const cls = `fa-${style} fa-${icon.id}`;

            $content.find(`[${attrs.list}]`).append(`<div ${attrs.icon}="${cls}"><i class="${cls}"></i></div>`);
        }

        const $empty = $content.find(`[${attrs.empty}]`);
        const isEmpty = $content.find(`[${attrs.icon}]`).length === 0;

        $empty.toggle(isEmpty);
    }

    /**
     * Show error message in the modal.
     */
    showError($content) {
        const attrs = this.options.attributes;

        $content.find(`[${attrs.icon}]`).remove();
        $content.find(`[${attrs.empty}]`).show();
    }

    /**
     * Save the selected icon to the input.
     */
    saveSelection($content) {
        const attrs = this.options.attributes;
        const $selected = $content.find(`[${attrs.icon}].selected`);

        if ($selected.length === 0) {
            return;
        }

        this.$input.val($selected.attr(attrs.icon)).trigger('change');
    }
}
