class RedotToasts {
    /**
     * The singleton instance of the plugin.
     */
    static instance = null;

    /**
     * Toast container placement classes, keyed by position.
     */
    static positions = {
        'top-left': 'top-0 start-0',
        'top-center': 'top-0 start-50 translate-middle-x',
        'top-right': 'top-0 end-0',
        'center-left': 'top-50 start-0 translate-middle-y',
        'center-center': 'top-50 start-50 translate-middle',
        'center-right': 'top-50 end-0 translate-middle-y',
        'bottom-left': 'bottom-0 start-0',
        'bottom-center': 'bottom-0 start-50 translate-middle-x',
        'bottom-right': 'bottom-0 end-0',
    };

    /**
     * Create a new instance.
     */
    constructor(config = {}) {
        if (RedotToasts.instance !== null) {
            return RedotToasts.instance;
        }

        RedotToasts.instance = this;

        this.toastifiers = config.toastifiers;
        this.defaults = config.defaults;
        this.containers = {};

        this.registerToastify();
        this.registerLivewire();
    }

    /**
     * Display a toast.
     */
    show(type, title, message = null, options = {}) {
        options = { ...this.defaults, ...options };

        const $container = this.container(options.position);
        const $toast = this.build(type, title, message, options);
        $toast.appendTo($container);
        $toast.on('hidden.bs.toast', () => $toast.remove());

        const toast = new tabler.Toast($toast.get(0), {
            autohide: options.autohide,
            delay: options.delay,
        });

        toast.show();

        // Scroll to the bottom of the container.
        requestAnimationFrame(() => {
            $container.prop('scrollTop', $container.prop('scrollHeight'));
        });

        return toast;
    }

    /**
     * Build the toast element.
     *
     * A toast without a message renders its title as the body with no
     * header, otherwise the default header/body layout is used.
     */
    build(type, title, message, options) {
        const icon = this.icon(type);
        const closeBtn = options.close ? this.close(message ? '' : 'me-2 m-auto') : '';

        const inner = message
            ? `<div class="toast-header">${icon}<strong class="me-auto">${title}</strong>${closeBtn}</div><div class="toast-body">${message}</div>`
            : `<div class="toast-body d-flex align-items-center">${icon}${title}${closeBtn}</div>`;

        return $(`
            <div class="toast fade ${message ? '' : 'align-items-center'}" role="alert" aria-live="assertive" aria-atomic="true">
                ${inner}
            </div>
        `);
    }

    /**
     * Build the icon of the given toastifier type.
     */
    icon(type) {
        const { icon, color } = this.toastifiers[type];

        return icon ? `<i class="icon me-2 ${icon}" style="color: ${color ?? 'currentColor'}"></i>` : '';
    }

    /**
     * Build the toast close button.
     */
    close(classes = '') {
        return `<button type="button" class="btn-close ${classes}" data-bs-dismiss="toast" aria-label="${__('Close')}"></button>`;
    }

    /**
     * Get or create the toast container for the given position.
     */
    container(position) {
        if (this.containers[position]) {
            return this.containers[position];
        }

        const placement = RedotToasts.positions[position];
        const $container = $(`<div class="toast-container position-fixed p-3 ${placement}"></div>`);

        this.containers[position] = $container.appendTo(document.body);

        return this.containers[position];
    }

    /**
     * Register the global `toastify()` helper, where any toastifier type is
     * callable (e.g. `toastify().success(title, message, options)`), and
     * expose the configured toastifiers on jQuery (e.g. `$.success(...)`).
     */
    registerToastify() {
        const toastifiers = new Proxy(
            {},
            {
                get:
                    (target, type) =>
                    (title, message = null, options = {}) =>
                        this.show(type, title, message, options),
            },
        );

        window.toastify = () => toastifiers;

        Object.keys(this.toastifiers).forEach((type) => ($[type] = toastifiers[type]));
    }

    /**
     * Display toasts dispatched from Livewire components.
     */
    registerLivewire() {
        const listen = () => {
            Livewire.on('toastify', ([title, message, type, options = {}]) => {
                this.show(type, title, message, options);
            });
        };

        if (typeof Livewire !== 'undefined') {
            listen();
        } else {
            document.addEventListener('livewire:init', () => {
                listen();
            });
        }
    }
}
