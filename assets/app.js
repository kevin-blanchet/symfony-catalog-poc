/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

// load jquery
import $ from 'jquery';

$(document).ready(function() {
    const $productSelect = $('.js-product-form-productType');
    const $optionsTarget = $('.js-options-target');
    $productSelect.on('change', function(e) {
        $.ajax({
            url: $productSelect.data('options-url'),
            data: {
                productType: $productSelect.val()
            },
            success: function (html) {
                if (!html) {
                    $optionsTarget.find('select').remove();
                    $optionsTarget.addClass('d-none');
                    return;
                }
                // Replace the current field and show
                $optionsTarget
                    .html(html)
                    .removeClass('d-none')
            }
        });
    });

    $(".js-form-search button[type='submit']").click(function(e) {
        e.stopPropagation();
        e.preventDefault();
        const $productSearch = $('.js-product-form-search');
        const $resultsTarget = $('.js-results-target');
        $.ajax({
            url: $productSearch.data('search-url')+'/'+$productSearch.val(),
            success: function (html) {
                // Replace the current field and show
                $resultsTarget
                    .html(html)
            }
        });
    });
});