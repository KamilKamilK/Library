const URL = `http://${window.location.host}`;

(function ($) {
    $(document).ready(function () {

        if (window.location.href.indexOf(`${URL}/book/edit`) === 0) {
            setTimeout(function () {
                handleAuthorList();
            }, 500);
        }

        let $wrapper = $('.js-tools-wrapper');

        $wrapper.on('click', '.js-remove-author', function (e) {
            e.preventDefault();

            let item = $(this).closest('.js-tool-item')

            $(this).closest('.js-tool-item')
                .fadeOut()
                .remove();

            console.log($(this).closest('.js-tool-item'));

            let authorId = item.find('input[type="hidden"]').attr('value')

            console.log(authorId)
            let bookId = $('.author-list').attr('id');
            let deleteAuthorUrl = `${URL}/author/remove/${bookId}/${authorId}`;

            $.ajax({
                url: deleteAuthorUrl,
                type: 'POST',
                success: function () {
                }
            })
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
            let bookId = $('.author-list').attr('id');
            let getAuthorsUrl = `${URL}/book/edit/${bookId}`;

            $.ajax({
                url: getAuthorsUrl,
                type: 'POST',
                success: function (response) {
                    let parsedResponse = JSON.parse(response);
                    let $authors = parsedResponse.authors;

                    let addButton = $('.js-author-add');
                    let table = addButton.closest('.text-center');

                    let index = 100;
                    $authors.forEach(function (author) {
                        let authorItem = buildAuthorItem(author, index)

                        index++
                        table.append(authorItem);
                        $wrapper.append(table);
                        authorItem.insertBefore(addButton)
                    });
                }
            });
        }

        function buildAuthorItem(author, index) {
            let idInput = $('<input>')
                .attr('type', 'hidden')
                .attr('name', `book[authors][${index}][id]`)
                .val(author.id)

            let dangerBtn = $('<button>').addClass('btn btn-danger btn-sm js-remove-author')
                .text('- Remove Author');

            let authorDiv = $('<div>').addClass('mb-3');
            let authorLabel = $('<label>')
                .attr('class', 'form-label required')
                .attr('for', `book_authors_${index}_name`)
                .text('Author name');
            let authorNameInput = $('<input>')
                .attr('type', 'text')
                .attr('name', `book[authors][${index}][name]`)
                .attr('class', 'js-author-name form-control')
                .val(author.name);

            let countryDiv = $('<div>').addClass('mb-3');
            let countryLabel = $('<label>')
                .attr('class', 'form-label required')
                .attr('for', `book_authors_${index}_country`)
                .text('Author country');
            let authorCountryInput = $('<input>')
                .attr('type', 'text')
                .attr('name', `book[authors][${index}][country]`)
                .attr('class', 'js-author-country form-control')
                .val(author.country);

            let authorItem = $('<div>').addClass('col-xs-4 js-tool-item');

            authorDiv.append(authorLabel).append(authorNameInput);
            countryDiv.append(countryLabel).append(authorCountryInput);

            return authorItem.append(idInput).append(dangerBtn).append(authorDiv).append(countryDiv);
        }
    });
})(jQuery);