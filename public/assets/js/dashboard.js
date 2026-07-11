$(function () {
    const $search = $('#search-pages');

    // Early return if the search input is not found
    if (!$search.length) return;

    const $menu = $('#sidebar-menu');
    const $container = $search.closest('.dashboard-search');
    const $results = $('<div class="dropdown-menu p-1"></div>').appendTo($container);

    // Normalize the value to remove extra spaces
    const normalize = (value) => value.toString().trim().replace(/\s+/g, ' ');

    // Array to store the pages
    const pages = [];

    // Collect the pages
    const collect = ($link, parent, fallbackIcon) => {
        const href = $link.attr('href');
        const title = normalize($link.find('.nav-link-title, .dropdown-item-title').text());
        const icon = $link.find('.nav-link-icon, .dropdown-item-icon').html() || fallbackIcon;

        // Early return if the href is not found or is a hash or the title is not found
        if (!href || href === '#' || !title) return;

        // Add the page to the pages array
        pages.push({ title, href, parent, icon, target: $link.attr('target') || '' });
    };

    // Collect the pages from the menu
    $menu.find('.navbar-nav > .nav-item > .nav-link[href]').each(function () {
        collect($(this), '', '');
    });

    // Collect the pages from the dropdowns
    $menu.find('.navbar-nav > .dropdown').each(function () {
        const $dropdown = $(this);
        const parent = normalize($dropdown.find('> .nav-link').text());
        const parentIcon = $dropdown.find('> .nav-link .nav-link-icon').html() || '';

        $dropdown.find('.dropdown-item[href]').each(function () {
            collect($(this), parent, parentIcon);
        });
    });

    // Hide the results
    const hide = () => $results.removeClass('show').empty();

    // Render the results
    const render = () => {
        const query = normalize($search.val()).toLowerCase();

        // Early return if the query is not found
        if (!query) return hide();

        // Filter the pages by the query
        const matches = pages.filter((page) => [page.title, page.parent].join(' ').toLowerCase().includes(query));

        // Empty the results and toggle the show class if there are matches
        $results.empty().toggleClass('show', matches.length > 0);

        // Loop through the matches and add the items to the results
        matches.forEach((page) => {
            const breadcrumb = [__('Dashboard')].concat(page.parent ? [page.parent] : []).join(' › ');

            // Add the item to the results
            $results.append(`
                <a class="dropdown-item rounded-2 d-flex align-items-center" href="${$('<div>').text(page.href).html()}"${page.target ? ` target="${$('<div>').text(page.target).html()}"` : ''}>
                    <span class="avatar avatar-sm bg-primary-lt me-2 flex-shrink-0">${page.icon || '<i class="fa fa-circle"></i>'}</span>
                    <div class="text-truncate">
                        <div class="text-secondary small text-truncate">${$('<div>').text(breadcrumb).html()}</div>
                        <div class="text-truncate fw-bold">${$('<div>').text(page.title).html()}</div>
                    </div>
                </a>
            `);
        });
    };

    // On input or focus, render the results
    $search.on('input focus', render);

    // On keydown, if the key is Escape, hide the results and blur the search
    $search.on('keydown', (event) => {
        if (event.key !== 'Escape') return;

        hide();
        $search.trigger('blur');
    });

    // On mousedown, if the target is not a child of the search container, hide the results
    $(document).on('mousedown', (event) => {
        if (!$(event.target).closest('.dashboard-search').length) hide();
    });
});
