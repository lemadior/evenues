/**
 * Call 'submit' method on /admin/{events|venues} page
 * when changed amount of items displayed per page
 */

const perPage = document.getElementById('per_page');

perPage.addEventListener('change', function (event) {
    const perPage = event.target.value;
    console.log(window.location.href);

    const url = new URL(window.location.href);
    const isPaginate = url.searchParams.get('per_page');

    if (isPaginate) {
        url.searchParams.set('per_page', perPage);
    } else {
        url.searchParams.set('page', '1');
        url.searchParams.set('per_page', perPage);
    }

    window.location.href = url.toString();
});
