/**
 * Allows to set methods to anchor links or other elements.
 *
 * Usage
 *   Set the href for the route to hit, any query parameter will be sent in the form as input.
 *   Set the class `as-submit` to the element
 *   Set the method attribute to use DELETE or PUT, by default will be POST
 *
 */
var anchorSubmit = function () {
    const links = $('.as-submit');
    const token = $('meta[name="csrf-token"]').attr('content');
    const body = $('body');

    links.each(function (i, link) {
        console.log(link);
        $(link).click(function(e) {
            e.preventDefault();

            const link = $(this);
            const url = link.attr('href').split('?');
            const params = (url.length > 1) ? url[1].split('&') : []
            const method = link.attr('method');

            let form = $('<form>')
                .attr('method', 'POST')
                .attr('action', url[0])
                .hide();

            for (var i = 0; i < params.length;i++) {
                let value = params[i].split('=');
                form.append($('<input>')
                    .attr('type', 'text')
                    .attr('name', value[0])
                    .attr('value', value[1])
                    .attr('autocomplete', 'off')
                );
            }

            if (token !== undefined) {
                form.append($('<input>')
                    .attr('type', 'hidden')
                    .attr('name', '_token')
                    .attr('value', token)
                    .attr('autocomplete', 'off')
                );
            }

            if (method !== undefined && method !== 'POST') {
                form.append($('<input>')
                    .attr('type', 'hidden')
                    .attr('name', '_method')
                    .attr('value', method)
                );
            }

            body.append(form);
            form.submit();
        });
    });
}

$(document).ready(function () {
    anchorSubmit();
});
