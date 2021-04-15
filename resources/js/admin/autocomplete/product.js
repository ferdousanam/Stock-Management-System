window.productSuggestions = function (callback) {
    return {
        source: function (request, response) {
            const {uiAutocomplete, ...data} = $(this.element.get(0)).data();
            const params = {};
            Object.keys(data).forEach(key => {
                params[key] = $(this.element.get(0)).attr('data-' + key);
            })
            $.ajax({
                type: 'get',
                url: window.base_url + '/api/products/suggestions',
                dataType: "json",
                data: {
                    ...params,
                    q: request.term
                },
                success: function (data) {
                    $(this).removeClass('ui-autocomplete-loading');
                    response($.map(data.data, function (item) {
                        return {
                            ...item,
                            label: `${item.title} (${item.product_code})`,
                            value: item.id
                        };
                    }));
                }
            });
        },
        minLength: 1,
        autoFocus: false,
        delay: 250,
        response: function (event, ui) {
            if ($(this).val().length >= 16 && ui.content[0].id === 0) {
                //audio_error.play();
                bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.', function () {
                    $('#add_item').focus();
                });
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            } else if (ui.content.length === 1 && ui.content[0].id !== 0) {
                ui.item = ui.content[0];
                $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                $(this).autocomplete('close');
                $(this).removeClass('ui-autocomplete-loading');
            } else if (ui.content.length === 1 && ui.content[0].id === 0) {
                //audio_error.play();
                bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.', function () {
                    $('#add_item').focus();
                });
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
        },
        select: function (event, ui) {
            event.preventDefault();
            if (ui.item.id !== 0) {
                callback(ui.item);
            } else {
                //audio_error.play();
                bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.');
            }
        }
    };
}
