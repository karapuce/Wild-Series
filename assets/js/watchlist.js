
import '../css/app.scss';



var watchlists = document.querySelectorAll(".watch");

Array.from(watchlists).forEach(link => {
    link.addEventListener('click', function(event) {
        // Get the link object you click in the DOM
        let watchlistIcon = event.target;
        let link = watchlistIcon.dataset.href;
// Send an HTTP request with fetch to the URI defined in the href
        fetch(link)
            .then(function(res) {

                watchlistIcon.classList.toggle('far'); // Remove the .far (empty heart) from classes in <i> element
                watchlistIcon.classList.toggle('fas'); // Add the .fas (full heart) from classes in <i> element
            });
    });
});