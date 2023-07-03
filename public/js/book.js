(function ($) {
    $(document).ready(function() {
        let $wrapper = $('.js-tools-wrapper');

        $wrapper.on('click', '.js-remove-tool', function(e) {
            e.preventDefault();

            $(this).closest('.js-tool-item')
                .fadeOut()
                .remove();
        });

        $wrapper.on('click', '.js-tool-add', function(e) {
            e.preventDefault();

            let prototype = $wrapper.data('prototype');

            let index = $wrapper.data('index');

            let newForm = prototype.replace(/__name__/g, index);

            $wrapper.data('index', index + 1);

            $(this).before(newForm);
        });
    });
})(jQuery);