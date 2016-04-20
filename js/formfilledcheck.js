//####### Alert Changes ##################################################################
// Utilizes two classes:
// .alertChanges  - Will listen for changes on any :input child elements.
//                  If a change occurs, the user will be be prompted before navigating away
// .bypassChanges - Sometimes the user has already indicated they want to save any changes
//                  by clicking cancel or save.  Add this class so the user will not be
//                  bothered with an extra popup
// Note: cannot guarantee that the user didn't change a value and later revert it
// http://stackoverflow.com/a/6579437/1366033


// IIFE automatically runs
(function ($, window) {

    // jQuery Extension
    // The handler is executed at most once for all elements for all event types.
    $.fn.only = function (events, callback) {

        // add listener and save original collection as jQuery object
        var $this = $(this).on(events, myCallback);

        // when callback fires, remove event handler and raise passed in function
        function myCallback(e) {
            $this.off(events, myCallback);
            callback.call(this, e);
        }

        // return original collection
        return this;
    };


    // Wait for document ready
    $(function () {

        var $alerts = $(".alertChanges");

        // only run if we have an element of interest
        if ($alerts.length) {

            var needToConfirm = false;

            // check before leaving
            window.onbeforeunload = askConfirm;

            function askConfirm() {
                if (needToConfirm) {
                    return "Are you sure you want to navigate away? Any unsaved data will be lost.";
                }
            }

            // wait for any other page changes
            setTimeout(function () {
                needToConfirm = false;
                listenForChanges();
            }, 1000);

            // if any input element changes, we'll need to confirm exit
            function listenForChanges() {
                $alerts.find(":input").only('change', function () {
                    needToConfirm = true;
                });
            }

            // disable confirmation message for select elements
            $(".bypassChanges").click(function () {
                needToConfirm = false;
            });

        }

    });
})(jQuery, window);