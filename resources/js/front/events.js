export function initEvents() {

    // parkTab scroll
    $('#parkTab .nav-link').off('click').on('click', function () {
        this.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    });

    // packageDetail scroll
    $('#packageDetailNav .nav-link').off('click').on('click', function () {
        this.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    });

    // filter open
    $('#openFilter').off('click').on('click', function () {
        $('.filter-sidebar-wrapper').addClass('active');
        $('body').addClass('overflow-hidden');
    });

    // filter close
    $('#closeFilter').off('click').on('click', function () {
        $('.filter-sidebar-wrapper').removeClass('active');
        $('body').removeClass('overflow-hidden');
    });
}

// footer scrollability
export function initScroll() {

    function checkScrollability() {
        const footer = document.querySelector('footer');
        if (document.body.scrollHeight <= window.innerHeight) {
            footer.classList.add('scrollnewclass');
        } else {
            footer.classList.remove('scrollnewclass');
        }
    }

    checkScrollability();
    window.addEventListener('resize', checkScrollability);
}
