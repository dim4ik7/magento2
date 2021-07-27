define([
    'jquery',
    'underscore',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/model/messageList'
], function ($, _, alert) {
    $.widget('mage.review', {
        options: {
            formSelector: '',
            submitUrl: '',
            messageSelector: ''
        },

        _create: function () {
            this._super();
            this._bindSubmit();
        },

        _bindSubmit: function () {
            $(this.options.formSelector).on('submit', this.formClick.bind(this))
        },

        formClick: function (e) {
            let self = this;
            e.preventDefault();
            // console.log('submit');
            $.ajax({
                url: this.options.submitUrl,
                type: 'GET',
                data: {
                    content: $('#content').val(),
                    author: $('#author').val(),
                    product_id: $('#product_id').val()
                },
            }).done(function (data) {
                console.log(data)
                if (data.success) {
                    console.log('ok');
                    $(self.options.formSelector).hide();
                    $(self.options.messageSelector).show();
                    setTimeout(function () {
                        $(self.options.messageSelector).hide();
                    }, 3000)
                } else {
                    alert({
                        title: $.mage.__('Something wrong'),
                        content: $.mage.__(data.error_message + '\nPlease, try again!')
                    });
                }
            }).error(function (qXHR, textStatus, errorThrown) {
                alert({
                    title: $.mage.__('Something wrong'),
                    content: $.mage.__('Please, try again!')
                });
                console.log(qXHR, textStatus, errorThrown)
            });
        }
    });

    return $.mage.review;
});
