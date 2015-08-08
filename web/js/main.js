$(document).ready(function(){


    /**
     * Запрос подтверждения
     * @param selector
     */
    var confirm_submit = function(selector) {

        var instance = this;
        this.form = false;
        this.button = false;
        this.popapsEl = false;
        this.message = 'Вы уверены ?';

        this.show = function() {
            $.tmpl('confirm_submit', {message: this.message}).appendTo(this.popapsEl.empty());
        };

        this.hide = function() {
            this.popapsEl.empty();
            this.removeEvents();
        };

        this.run = function(selector) {
            this.button = $(selector);
            this.form = this.button.closest('form');
            this.popapsEl = $('#popaps');
            this.message = this.button.data('confirm');

            this.button.on('click', function(e){
                instance.show();
                instance.addEvents();
                e.preventDefault();
            });
        };

        this.addEvents = function() {
            instance.popapsEl.on('click', '.no', function(){
                instance.hide();
            });

            instance.popapsEl.on('click', '.ok', function(){
                instance.hide();
                instance.form.submit();
            });
        };

        this.removeEvents = function() {
            instance.popapsEl.off('click', '.no');
            instance.popapsEl.off('click', '.ok');
        };

        $.template("confirm_submit",
            '<div class="confirm-submit-popap">' +
                '   <div class="message">${message}</div>' +
                '   <div class="buttons">' +
                '       <button class="ok">Да</button>' +
                '       <button class="no">Нет</button>' +
                '   </div>' +
                '</div>'
        );

        this.run(selector);

    };

    confirm_submit('.confirm-submit');

});
