/**
 * Simple AJAX Jquery searcher.
 * This loads an URL with the text to search at the end such as http://callbackurl/texttosearch
 * It acceptes a couple of options
 *  - resultsDiv the div where the results will be loaded // default '#results'
 *  - allDiv the div where all is shown so it can be hidden when showing results // default 'all'
 *  - minChars minimum chars to start searching // default 3
 */

(function($) {
    $.fn.searcher = function( callbackUrl , options ) {

        var settings = $.extend({
            resultsDiv   : 'results',
            allDiv       : 'all',
            minChars     : 3,
            onFound      : null,
        }, options);


        this.on('keyup',function(){
            var searchString = ($(this).val());
            if(searchString.length >= settings.minChars) {
                $('#' + settings.resultsDiv).show();
                $('#' + settings.allDiv).hide();
                $('#' + settings.resultsDiv).load(callbackUrl + $(this).val().replace(' ', '%20'), settings.onFound);
            }
            else{
                $('#' + settings.resultsDiv).hide();
                $('#' + settings.allDiv).show();
            }
        });
    }
}(jQuery));