        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="/js/jquery-ui-timepicker-addon.js"></script>
        <script src="/js/plugins.js"></script>
        <script src="/js/bootstrap.js"></script>
        <script src="/js/main.js"></script>
        <script src="/js/request-order.js"></script>

        <script>
            // jQuery datepicker opt-in.
            $("#datepicker").datepicker({
                beforeShowDay: function(date) {
                    var day = date.getDay();
                    return [(day != 1 && day != 6 && day != 2 && day != 0), ''];
                }
            });

            // jQuery timepicker opt-in.
            $('#timepicker').timepicker({
                hourMin: 8,
                hourMax: 17,
                stepMinute: 15,
                currentText: 'Aktuell tid',
                closeText: 'Klar',
                timeOnlyTitle: 'Önskad leveranstid',
                timeText: 'Tid',
                hourText: 'Timma',
                minuteText: 'Minut'
            });
        </script>




        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>