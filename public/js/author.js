const URL = `http://${window.location.host}`;

(function ($) {
    $(document).ready(function () {

        setTimeout(function () {
            handleAuthorList();
        }, 1000);

        let $wrapper = $('.js-tools-wrapper');

        $wrapper.on('click', '.js-remove-author', function (e) {
            e.preventDefault();

            $(this).closest('.js-tool-item')
                .fadeOut()
                .remove();
        });

        $wrapper.on('click', '.js-author-add', function (e) {
            e.preventDefault();

            let prototype = $wrapper.data('prototype');

            let index = $wrapper.data('index');

            let newForm = prototype.replace(/__name__/g, index);

            $wrapper.data('index', index + 1);

            $(this).before(newForm);
        });

        function handleAuthorList() {
            let bookId = $('.js-author-add').attr('id');
            let getAuthorsUrl = `${URL}/book/edit/${bookId}`;

            $.ajax({
                url: getAuthorsUrl,
                type: 'GET',
                success: function (response) {
                    let authors = response.authors;

                    let table = $('<div>').addClass('text-center');
                    table.empty();

                    $.each(authors, function (index, author) {
                        let dangerBtn = $('<button>').addClass('btn btn-danger btn-sm js-remove-author')
                            .text('- Remove Author');

                        let authorDiv = $('<div>').addClass('mb-3');
                        let authorLabel = $('<label>')
                            .addClass('form-label required')
                            .attr('for', `book_authors_${index}_name`)
                            .text('Author name');
                        let authorNameInput = $('<input>')
                            .attr('type', 'text')
                            .attr('name', `book[authors][${index}][name]`)
                            .addClass('js-author-name form-control')
                            .val(author.name);

                        let countryDiv = $('<div>').addClass('mb-3');
                        let countryLabel = $('<label>')
                            .addClass('form-label required')
                            .attr('for', `book_authors_${index}_country`)
                            .text('Author country');
                        let authorCountryInput = $('<input>')
                            .attr('type', 'text')
                            .attr('name', `book[authors][${index}][country]`)
                            .addClass('js-author-country form-control')
                            .val(author.country);

                        let authorItem = $('<div>').addClass('col-xs-4 js-tool-item');

                        authorDiv.append(authorLabel).append(authorNameInput);
                        countryDiv.append(countryLabel).append(authorCountryInput);

                        authorItem.append(dangerBtn).append(authorDiv).append(countryDiv);

                        table.append(authorItem);
                        $wrapper.append(table);

                        console.log(authorItem, author, authorDiv, countryDiv);
                    });
                }
            });
        }
    });
})(jQuery);