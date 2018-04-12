$(document).ready(function() {
    var lg = $("#lightgallery").lightGallery();
    var page = 1;
    $(window).scroll(function () {
        var scrollHeight = $(window).scrollTop() + $(window).height()+1;
        var sectionHeight = $("body").height();
        if (scrollHeight >= sectionHeight) getData();

        function getData() {
            page++;
            var url = (window.location.href +'/?page=' + page);
            getLinks(url);
        }

        function getLinks(url) {
            $.ajax({
                url: url,
                async: "true",
                cache: "false",
                success: function (data) {
                    $('.links').append(data);

                    if (window.location.pathname == '/gallery') {
                            lg.data('lightGallery').destroy(true);
                            lg = $("#lightgallery").lightGallery();
                            }
                },
                Error: function () {
                    alert("Link could not be loaded.");
                }
            });
        }
    })
});

