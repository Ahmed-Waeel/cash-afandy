$(() => {
    let $navbarTop = $('.site-navbar');
    let $navbarBottom = $('.site-navbar-bottom');

    if (!$navbarTop.length && !$navbarBottom.length) return;

    let setNavbarHeightVar = () => {
        let height = ($navbarTop.outerHeight() || 0) + ($navbarBottom.outerHeight() || 0);

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
