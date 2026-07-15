$(() => {
    let $navbarTop = $('.site-navbar');
    let $navbarBottom = $('.site-navbar-bottom');

    let setNavbarHeightVar = () => {
        let navbarBottomHeight = $navbarBottom.is(':visible') ? $navbarBottom.outerHeight() : 0;
        let height = ($navbarTop.outerHeight() || 0) + navbarBottomHeight;

        $(document.documentElement).css('--site-navbar-height', `${height}px`);
    };

    setNavbarHeightVar();
    $(window).on('resize', setNavbarHeightVar);

    if (window.ResizeObserver) {
        let observer = new ResizeObserver(setNavbarHeightVar);

        if ($navbarTop.length) observer.observe($navbarTop[0]);
        if ($navbarBottom.length) observer.observe($navbarBottom[0]);
    }
});

$(() => {
    let $cta = $('.site-navbar-cta').children('.btn');

    if (!$cta.length) return;

    let equalizeCtaWidth = () => {
        $cta.css('width', 'auto');

        let maxWidth = Math.max(...$cta.map((_, el) => $(el).outerWidth()).get());

        $cta.css('width', maxWidth);
    };

    equalizeCtaWidth();
    $(window).on('resize', equalizeCtaWidth);
});
