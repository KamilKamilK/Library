(function ($) {
    $(document).ready(function () {
        let $wrapper = $('.js-tools-wrapper');

        $wrapper.on('click', '.js-remove-tool', function (e) {
            e.preventDefault();

            $(this).closest('.js-tool-item')
                .fadeOut()
                .remove();
        });

        $wrapper.on('click', '.js-tool-add', function (e) {
            e.preventDefault();

            let prototype = $wrapper.data('prototype');

            let index = $wrapper.data('index');

            let newForm = prototype.replace(/__name__/g, index);

            $wrapper.data('index', index + 1);

            $(this).before(newForm);
        });

        // $('.edit-btn').click(function (e) {
        //     e.preventDefault();
        //     let editUrl = $(this).attr('href');
        //
        //     // Wywołaj żądanie AJAX, aby pobrać dane autora na podstawie URL edycji
        //     $.ajax({
        //         url: editUrl,
        //         type: 'GET',
        //         success: function (response) {
        //             // Pobierz dane autora z odpowiedzi AJAX
        //             let authorData = response.author;
        //
        //             // Iteruj przez pola autorów i uzupełnij wartości
        //             $('.js-tool-item').each(function (index) {
        //
        //                 // Sprawdź, czy istnieje odpowiedni obiekt danych autora
        //                 if (authorData[index]) {
        //                     let author = authorData[index];
        //
        //                     // Uzupełnij wartości pól name i country
        //                     // $authorName.val(author.name);
        //                     // $authorCountry.val(author.country);
        //
        //                     console.log(author)
        //                     // Tworzenie dynamicznego pola input dla nazwy autora
        //                     let authorNameInput = $('<input>')
        //                         .attr('type', 'text')
        //                         .attr('name', `book[authors][${index}][name]`)
        //                         .attr('class', 'js-author-name form-control')
        //                         .val(author.name);
        //
        //                     // Tworzenie dynamicznego pola input dla kraju autora
        //                     let authorCountryInput = $('<input>')
        //                         .attr('type', 'text')
        //                         .attr('name', `book[authors][${index}][country]`)
        //                         .attr('class', 'js-author-country form-control')
        //                         .val(author.country);
        //
        //                     // let $authorItem = $(this);
        //                     // let $authorName = $authorItem.find('.js-author-name');
        //                     // let $authorCountry = $authorItem.find('.js-author-country');
        //
        //                     // Podmiana istniejących pól input na nowe pola input
        //                     // $authorNameInput.replaceWith(authorNameInput);
        //                     // $authorCountryInput.replaceWith(authorCountryInput);
        //
        //                     // $authorNameInput.replaceWith($authorName);
        //                     // $authorCountryInput.replaceWith($authorCountry);
        //
        //                 }
        //             });
        //         },
        //         error: function (xhr, status, error) {
        //             // Obsłuż błąd żądania AJAX
        //             console.log(error);
        //         }
        //     });
        //
        //     window.location.href = $(this).attr('href');
        //
        // });
        // $wrapper.on('click', '.js-edit-author', function(e) {
        // $('.edit-btn').on('click', function(e) {
        //     e.preventDefault();
        //
        //     let $authorsTable = $('#book_authors');
        //     let $authorsRows = $authorsTable.find('.js-tool-item');
        //
        //     $authorsRows.each(function(index) {
        //         let $authorRow = $(this);
        //         let $authorNameInput = $authorRow.find('.js-author-name');
        //         let $authorCountryInput = $authorRow.find('.js-author-country');
        //
        //         let authorNameValue = $(`#book_authors_${index}_name`).val();
        //         let authorCountryValue = $(`#book_authors_${index}_country`).val();
        //
        //         console.log(authorNameValue, authorCountryValue)
        //         // Tworzenie dynamicznego pola input dla nazwy autora
        //         let authorNameInput = $('<input>')
        //             .attr('type', 'text')
        //             .attr('name', `book[authors][${index}][name]`)
        //             .val(authorNameValue);
        //
        //         // Tworzenie dynamicznego pola input dla kraju autora
        //         let authorCountryInput = $('<input>')
        //             .attr('type', 'text')
        //             .attr('name', `book[authors][${index}][country]`)
        //             .val(authorCountryValue);
        //
        //         // Podmiana istniejących pól input na nowe pola input
        //         $authorNameInput.replaceWith(authorNameInput);
        //         $authorCountryInput.replaceWith(authorCountryInput);
        //     });
        //
        //     window.location.href = $(this).attr('href');
        // });


        // $authorName.prop('readonly', false);
        // $authorCountry.prop('readonly', false);


        // $wrapper.on('click', '.edit-btn', function(e) {
        //     e.preventDefault();
        //
        //     console.log(this)
        //
        //     let $authorItem = $(this).closest('.js-tool-item');
        //     let $authorName = $authorItem.find('.js-author-name');
        //     let $authorCountry = $authorItem.find('.js-author-country');
        //
        //     id="book_authors_0_name"
        //
        //     $authorName.prop('readonly', false);
        //     $authorCountry.prop('readonly', false);
        // });

        // $wrapper.on('click', '.js-save-author', function (e) {
        //     e.preventDefault();
        //
        //     let $authorItem = $(this).closest('.js-tool-item');
        //     let $authorName = $authorItem.find('.js-author-name');
        //     let $authorCountry = $authorItem.find('.js-author-country');
        //
        //     $authorName.prop('readonly', true);
        //     $authorCountry.prop('readonly', true);
        // });
    });
})
(jQuery);