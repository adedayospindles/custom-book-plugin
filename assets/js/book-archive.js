document.addEventListener('DOMContentLoaded', function () {
    const genreSelect = document.getElementById('genre-select');
    const yearSelect = document.getElementById('year-select');
    const bookList = document.getElementById('book-list');

    if (genreSelect || yearSelect) {
        // Function to handle the change event for both genre and year filters
        function filterBooks() {
            const genre = genreSelect ? encodeURIComponent(genreSelect.value) : '0';
            const year = yearSelect ? encodeURIComponent(yearSelect.value) : '0';

            // Update the fetch URL to include both genre and year parameters
            fetch(`${book_ajax.url}?action=filter_books&genre=${genre}&year=${year}`)
                .then(response => response.text())
                .then(data => {
                    bookList.innerHTML = data;
                })
                .catch(error => console.error('Error fetching filtered books:', error));
        }

        // Add event listeners to trigger filtering
        [genreSelect, yearSelect].forEach(select => {
            if (select) select.addEventListener('change', filterBooks);
        });
    }
});