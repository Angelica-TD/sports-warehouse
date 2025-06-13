$(document).ready(function () {
    $('.num-in').each(function () {
        const $container = $(this);
        const $input = $container.find('input.in-num');
        const $minusBtn = $container.find('.minus');
        const $plusBtn = $container.find('.plus');
        const min = parseInt($input.attr('min')) || 1;
        const max = parseInt($input.attr('max')) || 10;

        // Initialize button state
        const updateButtons = (val) => {
            $minusBtn.toggleClass('dis', val <= min);
            $plusBtn.toggleClass('dis', val >= max);
        };

        updateButtons(parseInt($input.val()));

        $container.find('span').click(function () {
            let current = parseInt($input.val()) || min;
            if ($(this).hasClass('minus') && current > min) {
                current--;
            } else if ($(this).hasClass('plus') && current < max) {
                current++;
            }

            $input.val(current).change();
            updateButtons(current);
        });
    });
});
