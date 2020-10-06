/**
 * Components.js
 *
 * @author Anton Ustinoff <a.a.ustinoff@gmail.com>
 */

App.define('Components');

App.Components = (function() {
    function _init() {
        console.log('Site Components Init');
        App.Components.Input.init();
    }

    return {
        init: _init,
    };
})();

App.define('Components.Input');

App.Components.Input = (function() {
    function _init() {
        console.log('Site Components Input Init');
        _initMask();
    }

    function _initMask() {
        //Masked inputmask https://github.com/RobinHerbots/Inputmask
        let phoneMask = new Inputmask('+7 (999) 999-99-99');
        let inputPhone = $('.js-phone-mask');
        if (inputPhone) {
            phoneMask.mask(inputPhone);
        }
    }

    return {
        init: _init,
        initMask: _initMask,
    };
})();

//=include ../components/ajax.js
